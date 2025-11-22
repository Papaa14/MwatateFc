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

    public function destroy($id) {
        try {
            Fixture::destroy($id);
            return $this->sendResponse(null, 'Fixture deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete fixture: ' . $e->getMessage());
        }
    }
}
