<?php

namespace App\Http\Controllers;

use App\Models\Journal;

class StatisticController extends Controller
{
    public function entries()
    {
        $totalJournals = Journal::where('user_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return response()->json([
            "current_month_journals" => $totalJournals
        ], 200);
    }

    public function wordsWritten()
    {
        $totalWords = Journal::where('user_id', auth()->id())
            ->get()
            ->sum(function ($journal) {
                return str_word_count($journal->description);
            });

        return response()->json([
            "total_words_written" => $totalWords
        ], 200);
    }

    public function commonMoods()
    {
        $mostUsedMood = Journal::where('user_id', auth()->id())
            ->selectRaw('mood, COUNT(*) as total')
            ->groupBy('mood')
            ->orderByDesc('total')
            ->first();

        return response()->json([
            'mood' => $mostUsedMood->mood,
            'count' => $mostUsedMood->total,
        ]);
    }

    public function writingRhythm()
    {
        $data = Journal::where('user_id', auth()->id())
            ->selectRaw('DAY(created_at) as day, COUNT(*) as total')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return response()->json($data);
    }

    public function activeDays()
    {
        $days = Journal::where('user_id', auth()->id())
            ->selectRaw('DATE(created_at) as day')
            ->distinct()
            ->pluck('day');

        return response()->json($days);
    }
}
