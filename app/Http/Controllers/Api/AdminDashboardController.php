<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Mood;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function overview()
    {
        $userGrowth = User::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as new_users')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        $commonMoods = Journal::query()
            ->selectRaw('mood, COUNT(*) as entries')
            ->groupBy('mood')
            ->orderByDesc('entries')
            ->get();

        return response()->json([
            'total_user' => User::count(),
            'total_new_user' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'total_active_user' => Journal::where('created_at', '>=', now()->subDays(7))
                ->distinct()
                ->count('user_id'),
            'total_entries' => Journal::count(),
            'user_growth' => $userGrowth,
            'common_moods' => $commonMoods,
        ]);
    }
}
