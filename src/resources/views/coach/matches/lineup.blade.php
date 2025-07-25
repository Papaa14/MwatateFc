<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LineupController extends Controller
{
    public function show()
    {
        $players = User::where('role', 'player')->take(11)->get();
        $substitutes = User::where('role', 'player')->skip(11)->take(7)->get();
        return view('coach.matches.lineup', compact('players', 'substitutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formation' => 'required|string',
            'players' => 'required|array|size:11',
            'players.*.id' => 'required|exists:users,id',
            'players.*.position' => 'required|string',
        ]);

        // Save lineup logic here (e.g., save to a Lineup model/table)
        // Example: Lineup::create([...]);

        return redirect()->route('coach.lineup.show')->with('success', 'Lineup saved successfully!');
    }
}
