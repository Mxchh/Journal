<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StreakController extends Controller
{
    public function streak(Request $request) {
        $user = $request->user();
        $days = Journal::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->pluck('created_at')
            ->map(fn ($createdAt) => Carbon::parse($createdAt, 'UTC')
                ->setTimezone('Asia/Kuala_Lumpur')
                ->toDateString())
            ->unique()
            ->sortDesc()
            ->values();
        $streak=0;

        if ($days->isNotEmpty()) {
            $expectedDate = Carbon::parse($days[0], 'Asia/Kuala_Lumpur');

            foreach($days as $day){
                if($day===$expectedDate->toDateString())
                    {
                        $streak++;
                        $expectedDate->subDay();
                    } else{
                        break;
                    }
            }
        }
        $weeklyDays = [];
        $monday = Carbon::today('Asia/Kuala_Lumpur')->startOfWeek(Carbon::MONDAY);
        for ($i = 0; $i < 7; $i++) {
            $date = $monday->copy()->addDays($i)->toDateString();

            $exists = $days->contains($date);

            $weeklyDays[] =$exists;
        }

        return response()->json([
            'current_streak'=>$streak,
            'week_progress'=>collect($weeklyDays)
            ->filter()
            ->count(),
            'week_days'=>$weeklyDays,
        ]);
    }
}
