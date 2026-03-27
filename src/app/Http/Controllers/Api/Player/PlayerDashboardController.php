<?php
namespace App\Http\Controllers\Api\Player;
use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class PlayerDashboardController extends Controller
{
    public function stats(Request $request) {
        $user = $request->user();
        
        // Fetch real data
        $nextMatch = Fixture::where('match_date', '>=', now())
            ->orderBy('match_date', 'asc')->first();

        $nextTraining = TrainingSession::where('date', '>=', now())
            ->orderBy('date', 'asc')->first();

        // Fetch player stats from database
        $playerStats = $user->stats()->orderBy('created_at', 'desc')->get();
        
        // Calculate career totals
        $careerStats = [
            'goals' => $playerStats->sum('goals'),
            'assists' => $playerStats->sum('assists'),
            'appearances' => $playerStats->sum('appearances'),
            'minutes_played' => $playerStats->sum('minutes_played'),
            'yellow_cards' => $playerStats->sum('yellow_cards'),
            'red_cards' => $playerStats->sum('red_cards'),
        ];

        $stats = [
            'career_stats' => $careerStats,
            'history' => $playerStats,
            'next_match' => $nextMatch,
            'next_training' => $nextTraining
        ];

        return response()->json(['data' => $stats]);
    }

    public function trainings(Request $request) {
        // Fetch training sessions
        $trainings = TrainingSession::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        return response()->json(['data' => $trainings]);
    }
}

