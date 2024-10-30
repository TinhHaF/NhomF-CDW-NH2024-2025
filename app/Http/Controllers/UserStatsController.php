<?php

namespace App\Http\Controllers;

use App\Services\UserStatsService;
use Illuminate\Http\JsonResponse;

class UserStatsController extends Controller
{
    protected $userStatsService;

    public function __construct(UserStatsService $userStatsService)
    {
        $this->userStatsService = $userStatsService;
    }

    public function getOnlineUsers(): JsonResponse
    {
        $onlineUsers = $this->userStatsService->getOnlineUsers();
        return response()->json(['count' => $onlineUsers]);
    }

    public function getWeeklyVisits(): JsonResponse
    {
        $weeklyVisits = $this->userStatsService->getWeeklyVisits();
        return response()->json(['count' => $weeklyVisits]);
    }

    public function getMonthlyVisits(): JsonResponse
    {
        $monthlyVisits = $this->userStatsService->getMonthlyVisits();
        return response()->json(['count' => $monthlyVisits]);
    }

    public function getTotalVisits(): JsonResponse
    {
        $totalVisits = $this->userStatsService->getTotalVisits();
        return response()->json(['count' => $totalVisits]);
    }
}
