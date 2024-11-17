<?php

namespace App\Services;

use App\Models\Visit;
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
        $cacheKey = "visit_{$ip}_" . ($isAdmin ? 'admin' : 'site');

        if (!Cache::has($cacheKey)) {
            Visit::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'page_url' => $request->fullUrl(),
                'is_admin' => $isAdmin,
                'visited_at' => now(),
            ]);

            // Cache trong 30 phút
            Cache::put($cacheKey, true, 30 * 60);

            // Log để xác nhận có một lượt truy cập mới
            Log::info("New visitor tracked: {$ip}");
        } else {
            // Log rằng lượt truy cập đã được theo dõi trước đó
            Log::info("Visitor already tracked: {$ip}");
        }
    }

    public function getStatistics()
    {
        return [
            'onlineUsers' => $this->getOnlineUsers(),
            'weeklyVisits' => $this->getWeeklyVisits(),
            'monthlyVisits' => $this->getMonthlyVisits(),
            'totalVisits' => Visit::count(),
            'dates' => $this->getLastThirtyDays(),
            'visitCounts' => $this->getVisitCountsByDay(),
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

    private function getLastThirtyDays()
    {
        return collect(range(29, 0))
            ->map(fn($days) => now()->subDays($days)->format('d/m'))
            ->toArray();
    }

    private function getVisitCountsByDay()
    {
        return collect(range(29, 0))->map(function ($days) {
            $date = now()->subDays($days)->format('Y-m-d');
            return Visit::whereDate('visited_at', $date)->count();
        })->toArray();
    }

    public function getVisitsByPeriod($period)
    {
        return Visit::where('visited_at', '>=', now()->subDays($period))
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
