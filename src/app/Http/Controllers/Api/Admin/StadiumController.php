<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    public function index()
    {
        // Load stadiums with their tickets to show summary
        $stadiums = Stadium::with(['fixtures.tickets'])->get()->map(function ($stadium) {
            // Calculate total tickets for this stadium
            $totalTickets = $stadium->fixtures->sum(function ($fixture) {
                return $fixture->tickets->count();
            });

            return [
                'id' => $stadium->id,
                'name' => $stadium->name,
                'capacity' => $stadium->capacity,
                'sections_config' => $stadium->sections_config,
                'fixtures_count' => $stadium->fixtures->count(),
                'tickets_count' => $totalTickets,
                'created_at' => $stadium->created_at,
                'updated_at' => $stadium->updated_at,
            ];
        });

        return $this->sendResponse($stadiums, 'Stadiums retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'sections_config' => 'nullable|json',
        ]);

        // Decode sections_config if it's a string
        $data = $request->all();
        if (is_string($data['sections_config'] ?? null)) {
            $data['sections_config'] = json_decode($data['sections_config'], true);
        }

        $stadium = Stadium::create($data);

        // Generate tickets for existing fixtures if sections are configured
        if (!empty($stadium->sections_config)) {
            $stadium->generateTickets();
        }

        return $this->sendResponse($stadium, 'Stadium created successfully');
    }

    public function update(Request $request, $id)
    {
        $stadium = Stadium::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'sections_config' => 'nullable|json',
        ]);

        // Decode sections_config if it's a string
        $data = $request->all();
        if (is_string($data['sections_config'] ?? null)) {
            $data['sections_config'] = json_decode($data['sections_config'], true);
        }

        $stadium->update($data);

        // Regenerate tickets for all fixtures if sections are configured
        if (!empty($stadium->sections_config)) {
            $stadium->generateTickets();
        }

        return $this->sendResponse($stadium, 'Stadium updated successfully');
    }

    public function destroy($id)
    {
        Stadium::destroy($id);
        return $this->sendResponse(null, 'Stadium deleted successfully');
    }
}
