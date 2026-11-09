<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StreakController extends Controller
{
    public function streak(Request $request) {
        $user = $request->user();
        $days = Journal::where('user_id', $user->id)
        ->selectRaw('DATE(created_at) as day')
        ->distinct()
        ->orderBy('day','desc')
        ->pluck('day')
        ->toArray();
        $streak=0;

        if(!empty($days)) {
            $expectedDate = Carbon::parse($days[0]);

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
        for($i=6; $i>=0; $i--) {
            $date = Carbon::today()
            ->subDays($i)
            ->toDateString();

            $exists = Journal::where('user_id', $user->id)
            ->whereDate('created_at', $date)
            ->exists();

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