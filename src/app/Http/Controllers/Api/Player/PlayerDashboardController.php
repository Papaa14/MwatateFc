<?php
namespace App\Http\Controllers\Api\Player;
use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class PlayerDashboardController extends Controller
{
    public function stats() {
        // Fetch real data
        $nextMatch = Fixture::where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')->first();

        $nextTraining = TrainingSession::where('date', '>=', now())
            ->orderBy('date', 'asc')->first();

        // You would usually fetch these from a PlayerStats model
        $stats = [
            'goals' => 12, // Replace with $user->goals
            'assists' => 8,
            'attendance' => '95%',
            'next_match' => $nextMatch,
            'next_training' => $nextTraining
        ];

        return response()->json(['data' => $stats]);
    }

    public function trainings() {
        // Fetch training sessions
        $trainings = TrainingSession::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        return response()->json(['data' => $trainings]);
    }
}
