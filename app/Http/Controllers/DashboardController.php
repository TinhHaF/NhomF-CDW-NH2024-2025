<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Visit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy ngày hiện tại
        $currentDate = now();
        $startDate = $currentDate->copy()->startOfMonth();
        $endDate = $currentDate->copy()->endOfMonth();

        // Lấy dữ liệu visits trong tháng hiện tại
        $visits = Visit::whereBetween('visited_at', [$startDate, $endDate])
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tạo mảng dates và visitCounts
        $dates = [];
        $visitCounts = [];
        $period = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate);

        foreach ($period as $date) {
            $dateStr = $date->format('d/m');
            $count = $visits->where('date', $date->format('Y-m-d'))->first()?->count ?? 0;
            $dates[] = $dateStr;
            $visitCounts[] = $count;
        }

        $statistics = [
            'onlineUsers' => Visit::online()->count(),
            'weeklyVisits' => Visit::thisWeek()->count(),
            'monthlyVisits' => Visit::thisMonth()->count(),
            'totalVisits' => Visit::count(),
            'dates' => $dates,
            'visitCounts' => $visitCounts,
            'browserStats' => $this->formatForHighcharts(Visit::getBrowserStats()),
            'deviceStats' => $this->formatForHighcharts(Visit::getDeviceStats()),
            'currentMonth' => $currentDate->format('m'),
            'currentYear' => $currentDate->format('Y')
        ];
        // Lấy bài viết có lượt xem cao nhất
        $mostViewedPost = Post::orderBy('view', 'desc')->first();

        // Gọi trackOnlineStatus để cập nhật trạng thái online của người dùng
        Visit::trackOnlineStatus($request);
        return view('admin.dashboard', compact('statistics', 'mostViewedPost'));
    }

    public function getChartData(Request $request)
    {
        $period = $request->input('period');
        $currentDate = now();

        if ($period == '24') {
            // Lấy dữ liệu 24 giờ
            $startDate = $currentDate->copy()->subHours(24);
            $endDate = $currentDate;
            $groupBy = 'HOUR(visited_at)';
        } elseif ($period == '7') {
            // Lấy dữ liệu 7 ngày
            $startDate = $currentDate->copy()->subDays(7);
            $endDate = $currentDate;
            $groupBy = 'DATE(visited_at)';
        } else {
            // Lấy dữ liệu tháng hiện tại
            $startDate = $currentDate->copy()->startOfMonth();
            $endDate = $currentDate->copy()->endOfMonth();
            $groupBy = 'DATE(visited_at)';
        }

        $visits = Visit::whereBetween('visited_at', [$startDate, $endDate])
            ->selectRaw("$groupBy as date, COUNT(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'visits' => $visits->pluck('count'),
            'dates' => $visits->pluck('date')
        ]);
    }

    private function getLastNDaysDates(int $days): array
    {
        return collect(range($days - 1, 0))
            ->map(fn($day) => now()->subDays($day)->format('d/m'))
            ->toArray();
    }

    private function formatForHighcharts(array $data): array
    {
        return collect($data)
            ->map(fn($value, $key) => [
                'name' => ucfirst($key),
                'y' => $value
            ])
            ->values()
            ->toArray();
    }
}
