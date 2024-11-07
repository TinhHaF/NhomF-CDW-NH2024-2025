<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\VisitorTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $visitorService;

    public function __construct(VisitorTrackingService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function index()
    {
        $statistics = $this->visitorService->getStatistics();

        // Thêm browser stats
        $statistics['browserStats'] = [
            ['name' => 'Chrome', 'y' => 45],
            ['name' => 'Firefox', 'y' => 25],
            ['name' => 'Safari', 'y' => 20],
            ['name' => 'Others', 'y' => 10]
        ];

        // Thêm device stats
        $statistics['deviceStats'] = [
            ['name' => 'Desktop', 'y' => 60],
            ['name' => 'Mobile', 'y' => 35],
            ['name' => 'Tablet', 'y' => 5]
        ];

        // Lấy dữ liệu lượt truy cập trong 30 ngày
        $data = $this->visitorService->getVisitsByPeriod(30);
        $statistics['dates'] = $data->pluck('date')->toArray();
        $statistics['visitCounts'] = $data->pluck('count')->toArray();

        // Truyền dữ liệu vào view
        return view('admin.dashboard.dashboard', compact('statistics'));
    }


    public function getChartData(Request $request)
    {
        $period = $request->get('period', 30);
        $data = $this->visitorService->getVisitsByPeriod($period);

        return response()->json([
            'dates' => $data->pluck('date'),
            'visitCounts' => $data->pluck('count')
        ]);
    }

    // public function getOnlineUsers(): JsonResponse
    // {
    //     $onlineUsers = $this->visitorService->getOnlineUsers();
    //     return response()->json(['count' => $onlineUsers]);
    // }

    // public function getWeeklyVisits(): JsonResponse
    // {
    //     $weeklyVisits = $this->visitorService->getWeeklyVisits();
    //     return response()->json(['count' => $weeklyVisits]);
    // }

    // public function getMonthlyVisits(): JsonResponse
    // {
    //     $monthlyVisits = $this->visitorService->getMonthlyVisits();
    //     return response()->json(['count' => $monthlyVisits]);
    // }

    // public function getTotalVisits(): JsonResponse
    // {
    //     $totalVisits = $this->visitorService->getTotalVisits();
    //     return response()->json(['count' => $totalVisits]);
    // }
}
