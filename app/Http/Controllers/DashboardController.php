<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Số người đang online (truy cập trong 5 phút gần nhất)
        $onlineUsers = Visitor::where('visited_at', '>=', Carbon::now()->subMinutes(5))
            ->distinct('ip_address')
            ->count();

        // Số truy cập trong tuần
        $weeklyVisits = Visitor::whereBetween('visited_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Số truy cập trong tháng
        $monthlyVisits = Visitor::whereBetween('visited_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->count();

        // Tổng số truy cập
        $totalVisits = Visitor::count();

        // Dữ liệu cho biểu đồ
        $chartData = collect(range(1, Carbon::now()->daysInMonth))->map(function($day) {
            $date = Carbon::now()->startOfMonth()->addDays($day - 1);
            return [
                'date' => $date->format('d/m'),
                'visits' => Visitor::whereDate('visited_at', $date)->count()
            ];
        });

        return view('admin.dashboard.dashboard', compact(
            'onlineUsers',
            'weeklyVisits',
            'monthlyVisits',
            'totalVisits',
            'chartData'
        ));
    }
    
}
