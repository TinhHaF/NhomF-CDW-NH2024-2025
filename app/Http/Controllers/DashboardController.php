<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     // Số người đang online (truy cập trong 5 phút gần nhất)
    //     $onlineUsers = Visitor::where('visit_date', '>=', Carbon::now()->subMinutes(5))
    //         ->distinct('ip_address')
    //         ->count();

    //     // Số truy cập trong tuần
    //     $weeklyVisits = Visitor::whereBetween('visit_date', [
    //         Carbon::now()->startOfWeek(),
    //         Carbon::now()->endOfWeek()
    //     ])->count();

    //     // Số truy cập trong tháng
    //     $monthlyVisits = Visitor::whereBetween('visit_date', [
    //         Carbon::now()->startOfMonth(),
    //         Carbon::now()->endOfMonth()
    //     ])->count();

    //     // Tổng số truy cập
    //     $totalVisits = Visitor::count();

    //     // Dữ liệu cho biểu đồ
    //     $chartData = collect(range(1, Carbon::now()->daysInMonth))->map(function($day) {
    //         $date = Carbon::now()->startOfMonth()->addDays($day - 1);
    //         return [
    //             'date' => $date->format('d/m'),
    //             'visits' => Visitor::whereDate('visit_date', $date)->count()
    //         ];
    //     });

    //     return view('admin.dashboard.dashboard', compact(
    //         'onlineUsers',
    //         'weeklyVisits',
    //         'monthlyVisits',
    //         'totalVisits',
    //         'chartData'
    //     ));
    // }

    public function index()
    {
        // Số người đang online (truy cập trong 5 phút gần nhất)
        $onlineUsers = Visit::where('visit_date', '>=', Carbon::now()->subMinutes(5))
            ->distinct('ip_address')
            ->count();

        // Số truy cập trong tuần
        $weeklyVisits = Visit::whereBetween('visit_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Số truy cập trong tháng
        $monthlyVisits = Visit::whereBetween('visit_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();

        // Tổng số truy cập
        $totalVisits = Visit::count();

        // Dữ liệu cho biểu đồ
        $visitsThisMonth = Visit::whereMonth('visit_date', Carbon::now()->month)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->visit_date)->format('d'); // Lấy ngày
            });

        $chartData = collect(range(1, Carbon::now()->daysInMonth))->map(function ($day) use ($visitsThisMonth) {
            return [
                'date' => sprintf("%02d/%02d", $day, Carbon::now()->month),
                'visits' => $visitsThisMonth->get($day, collect())->count()
            ];
        });

        // Thêm biến $dates và $visitCounts
        $dates = $chartData->pluck('date')->toArray(); // Lấy ngày từ chartData
        $visitCounts = $chartData->pluck('visits')->toArray(); // Lấy số lượt truy cập từ chartData

        return view('admin.dashboard.dashboard', compact(
            'onlineUsers',
            'weeklyVisits',
            'monthlyVisits',
            'totalVisits',
            'chartData',
            'dates',      // Thêm biến $dates vào view
            'visitCounts' // Thêm biến $visitCounts vào view
        ));
    }
}
