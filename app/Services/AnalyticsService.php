<?php

namespace App\Services;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function getStatistics()
    {
        return [
            'onlineUsers' => $this->getOnlineUsers(),
            'weeklyVisits' => $this->getWeeklyVisits(),
            'monthlyVisits' => $this->getMonthlyVisits(),
            'totalVisits' => $this->getTotalVisits(),
            'dates' => $this->getLastNDaysDates(30),
            'visitCounts' => $this->getVisitCountsByDays(30),
            'browserStats' => $this->getBrowserStats(),
            'deviceStats' => $this->getDeviceStats(),
        ];
    }

    private function getOnlineUsers()
    {
        return Visit::where('visited_at', '>=', now()->subMinutes(15))->count();
    }

    private function getWeeklyVisits()
    {
        return Visit::where('visited_at', '>=', now()->subDays(7))->count();
    }

    private function getMonthlyVisits()
    {
        return Visit::where('visited_at', '>=', now()->subDays(30))->count();
    }

    private function getTotalVisits()
    {
        return Visit::count();
    }

    private function getLastNDaysDates($days)
    {
        return collect(range($days - 1, 0))
            ->map(fn($day) => now()->subDays($day)->format('d/m'))
            ->toArray();
    }

    private function getVisitCountsByDays($days)
    {
        $visits = Visit::where('visited_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        return collect(range($days - 1, 0))
            ->map(function ($day) use ($visits) {
                $date = now()->subDays($day)->format('Y-m-d');
                return $visits->firstWhere('date', $date)?->count ?? 0;
            })
            ->toArray();
    }

    private function getBrowserStats()
    {
        return Visit::selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->get()
            ->map(fn($item) => ['name' => $item->browser, 'y' => $item->count])
            ->toArray();
    }

    private function getDeviceStats()
    {
        return Visit::selectRaw('device_type, COUNT(*) as count')
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->get()
            ->map(fn($item) => ['name' => $item->device_type, 'y' => $item->count])
            ->toArray();
    }
}
