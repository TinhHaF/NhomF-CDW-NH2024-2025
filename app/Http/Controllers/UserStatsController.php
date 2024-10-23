<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class UserStatsController extends Controller
{
    public function getOnlineUsers()
    {
        $onlineUsers = Cache::get('online_users_count', 0);
        return response()->json(['count' => $onlineUsers]);
    }

    public function getWeeklyVisits()
    {
        $week = date('W');
        $weeklyVisits = Cache::get("weekly_visits_{$week}", 0);
        return response()->json(['count' => $weeklyVisits]);
    }

    public function getMonthlyVisits()
    {
        $month = date('m-Y');
        $monthlyVisits = Cache::get("monthly_visits_{$month}", 0);
        return response()->json(['count' => $monthlyVisits]);
    }

    public function getTotalVisits()
    {
        $totalVisits = Cache::get('total_visits', 0);
        return response()->json(['count' => $totalVisits]);
    }
}
