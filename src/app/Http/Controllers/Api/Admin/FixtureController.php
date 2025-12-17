<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index() {
        return $this->sendResponse(Fixture::orderBy('match_date', 'asc')->get(), 'Fixtures retrieved successfully');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'opponent' => 'required|string',
                'match_date' => 'required|date',
                'venue' => 'required|in:Home,Away',
                'competition' => 'required|string',
            ]);

            $fixture = Fixture::create($request->all());
            return $this->sendResponse($fixture, 'Fixture created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create fixture: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $fixture = Fixture::findOrFail($id);

            $request->validate([
                'opponent' => 'sometimes|string',
                'match_date' => 'sometimes|date',
                'venue' => 'sometimes|in:Home,Away',
                'competition' => 'sometimes|string',
                'home_score' => 'nullable|integer|min:0',
                'away_score' => 'nullable|integer|min:0',
                'status' => 'sometimes|in:scheduled,live,fulltime'
            ]);

            $fixture->update($request->all());
            return $this->sendResponse($fixture, 'Fixture updated successfully');
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
