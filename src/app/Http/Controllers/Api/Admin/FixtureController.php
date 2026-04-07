<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\Stadium;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index() {
        $fixtures = Fixture::with('stadium')->orderBy('match_date', 'asc')->get();

        // Transform to include stadium info and sections in fixture
        $fixtures = $fixtures->map(function ($fixture) {
            return [
                'id' => $fixture->id,
                'opponent' => $fixture->opponent,
                'match_date' => $fixture->match_date,
                'venue' => $fixture->venue,
                'competition' => $fixture->competition,
                'stadium_id' => $fixture->stadium_id,
                'ticket_capacity' => $fixture->ticket_capacity,
                'tickets_sold' => $fixture->tickets_sold,
                'stadium_name' => $fixture->stadium?->name,
                'sections_config' => $fixture->stadium?->sections_config ?? [],
            ];
        });

        return $this->sendResponse($fixtures, 'Fixtures retrieved successfully');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'opponent' => 'required|string',
                'match_date' => 'required|date',
                'venue' => 'required|in:Home,Away',
                'competition' => 'required|string',
                'stadium_id' => 'required|exists:stadiums,id',
            ]);

            // Get stadium to auto-set ticket capacity
            $stadium = Stadium::findOrFail($request->stadium_id);

            $fixtureData = $request->all();
            $fixtureData['ticket_capacity'] = $stadium->capacity;

            $fixture = Fixture::create($fixtureData);

            // Generate tickets from stadium sections if they exist
            if ($stadium->sections_config && !empty($stadium->sections_config)) {
                $stadium->generateTickets();
            }

            return $this->sendResponse($fixture->load('stadium'), 'Fixture created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create fixture: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $fixture = Fixture::findOrFail($id);

            $request->validate([
                'opponent' => 'string',
                'match_date' => 'date',
                'venue' => 'in:Home,Away',
                'competition' => 'string',
                'stadium_id' => 'exists:stadiums,id',
            ]);

            // If stadium_id is being updated, auto-update ticket_capacity
            if ($request->has('stadium_id')) {
                $stadium = Stadium::findOrFail($request->stadium_id);
                $request->merge(['ticket_capacity' => $stadium->capacity]);

                // Regenerate tickets for new stadium
                if ($stadium->sections_config && !empty($stadium->sections_config)) {
                    $stadium->generateTickets();
                }
            }

            $fixture->update($request->all());
            return $this->sendResponse($fixture->load('stadium'), 'Fixture updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update fixture: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        try {
            Fixture::destroy($id);
            return $this->sendResponse(null, 'Fixture deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete fixture: ' . $e->getMessage());
        }
    }
}
