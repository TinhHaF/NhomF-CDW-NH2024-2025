<?php

namespace App\Services;

use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VisitorTrackingService
{
    public function trackVisit($request, $isAdmin = false)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Kiểm tra xem IP này đã truy cập trong 30 phút qua chưa
        $cacheKey = "visitor_{$ip}_" . ($isAdmin ? 'admin' : 'site');

        if (!Cache::has($cacheKey)) {
            Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'page_url' => $request->fullUrl(),
                'is_admin' => $isAdmin,
                'visited_at' => now(),
            ]);

            // Cache trong 30 phút
            Cache::put($cacheKey, true, 30 * 60);

            // Log to confirm that we created a new visitor
            Log::info("New visitor tracked: {$ip}");
        } else {
            // Log that the visitor has already been tracked
            Log::info("Visitor already tracked: {$ip}");
        }
    }

    public function getStatistics()
    {
        $now = now();

        return [
            'onlineUsers' => $this->getOnlineUsers(),
            'weeklyVisits' => $this->getWeeklyVisits(),
            'monthlyVisits' => $this->getMonthlyVisits(),
            'totalVisits' => Visitor::count(),
            'dates' => $this->getLastThirtyDays(),
            'visitCounts' => $this->getVisitCountsByDay(),
        ];
    }

    private function getOnlineUsers()
    {
        return Visitor::where('visited_at', '>=', now()->subMinutes(15))->count();
    }

    private function getWeeklyVisits()
    {
        return Visitor::where('visited_at', '>=', now()->subDays(7))->count();
    }

    private function getMonthlyVisits()
    {
        return Visitor::where('visited_at', '>=', now()->subDays(30))->count();
    }

    private function getLastThirtyDays()
    {
        return collect(range(29, 0))
            ->map(fn($days) => now()->subDays($days)->format('d/m'))
            ->toArray();
    }

    private function getVisitCountsByDay()
    {
        $counts = collect(range(29, 0))->map(function ($days) {
            $date = now()->subDays($days)->format('Y-m-d');
            return Visitor::whereDate('visited_at', $date)->count();
        });

        return $counts->toArray();
    }
    public function getVisitsByPeriod($period)
    {
        return Visitor::where('visited_at', '>=', now()->subDays($period))
            ->selectRaw('date(visited_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
