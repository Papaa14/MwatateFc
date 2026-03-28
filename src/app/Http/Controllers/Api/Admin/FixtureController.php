<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\Stadium;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index() {
        return $this->sendResponse(
            Fixture::with('stadium')->orderBy('match_date', 'asc')->get(),
            'Fixtures retrieved successfully'
        );
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
