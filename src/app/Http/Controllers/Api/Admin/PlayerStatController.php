<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerStat;
use App\Models\User;
use Illuminate\Http\Request;

class PlayerStatController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        
        if ($userId) {
            $stats = PlayerStat::where('user_id', $userId)
                ->orderBy('season', 'desc')
                ->get();
        } else {
            $stats = PlayerStat::with('user')->orderBy('created_at', 'desc')->get();
        }

        return $this->sendResponse($stats, 'Player stats retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'season' => 'required|string|max:10',
            'club_name' => 'required|string|max:255',
            'appearances' => 'required|integer|min:0',
            'goals' => 'required|integer|min:0',
            'assists' => 'required|integer|min:0',
            'yellow_cards' => 'required|integer|min:0',
            'red_cards' => 'required|integer|min:0',
            'minutes_played' => 'required|integer|min:0',
        ]);

        $stat = PlayerStat::create($request->all());

        return $this->sendResponse($stat, 'Player stat created successfully');
    }

    public function show($id)
    {
        $stat = PlayerStat::findOrFail($id);
        return $this->sendResponse($stat, 'Player stat retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $stat = PlayerStat::findOrFail($id);

        $request->validate([
            'season' => 'string|max:10',
            'club_name' => 'string|max:255',
            'appearances' => 'integer|min:0',
            'goals' => 'integer|min:0',
            'assists' => 'integer|min:0',
            'yellow_cards' => 'integer|min:0',
            'red_cards' => 'integer|min:0',
            'minutes_played' => 'integer|min:0',
        ]);

        $stat->update($request->all());

        return $this->sendResponse($stat, 'Player stat updated successfully');
    }

    public function destroy($id)
    {
        PlayerStat::destroy($id);
        return $this->sendResponse(null, 'Player stat deleted successfully');
    }
}
