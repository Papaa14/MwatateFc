<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    public function index() {
        return response()->json(['data' => TrainingSession::latest()->get()]);
    }

    public function store(Request $request) {
        $request->validate([
            'date' => 'required', 'time' => 'required', 'location' => 'required', 'type' => 'required'
        ]);
        $session = TrainingSession::create($request->all());
        return response()->json(['message' => 'Session created', 'data' => $session]);
    }
    // Implement show, update, destroy as needed
}
