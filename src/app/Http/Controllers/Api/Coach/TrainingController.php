<?php

namespace App\Http\Controllers\Api\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    public function index()
    {
        $plans = DB::table('training_plans')
            ->leftJoin('users', 'training_plans.coach_id', '=', 'users.id')
            ->select('training_plans.*', 'users.name as coach_name')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $plans]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required|string',
            'video_url' => 'nullable|url',
            'assigned_players' => 'required|array|min:1',
            'assigned_players.*' => 'integer|exists:users,id'
        ]);

        $planId = DB::table('training_plans')->insertGetId([
            'coach_id' => Auth::id(),
            'subject' => $validated['subject'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'video_url' => $validated['video_url'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Assign to players
        foreach ($validated['assigned_players'] as $playerId) {
            DB::table('training_plan_assignments')->insert([
                'training_plan_id' => $planId,
                'player_id' => $playerId,
                'created_at' => now()
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Training plan created successfully']);
    }

    public function getPlayerPlans(Request $request)
    {
        $userId = Auth::id();

        $plans = DB::table('training_plans')
            ->join('training_plan_assignments', 'training_plans.id', '=', 'training_plan_assignments.training_plan_id')
            ->leftJoin('users', 'training_plans.coach_id', '=', 'users.id')
            ->where('training_plan_assignments.player_id', $userId)
            ->select('training_plans.*', 'users.name as coach_name')
            ->orderBy('training_plans.created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $plans]);
    }
}
