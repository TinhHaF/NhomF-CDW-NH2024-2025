<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class UserStatsService
{
    public function getOnlineUsers()
    {
        return Cache::get('online_users_count', 0);
    }

    public function getWeeklyVisits()
    {
        $week = date('W');
        return Cache::get("weekly_visits_{$week}", 0);
    }

    public function getMonthlyVisits()
    {
        $month = date('m-Y');
        return Cache::get("monthly_visits_{$month}", 0);
    }

    public function getTotalVisits()
    {
        return Cache::get('total_visits', 0);
    }
}
