<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;

class TrackVisits
{
    protected $visitorService;

    public function __construct(AnalyticsService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->shouldSkipTracking($request)) {
            return $next($request);
        }

        Visit::track($request, Auth::id());

        return $next($request);
    }
    private function shouldSkipTracking(Request $request): bool
    {
        // Loại trừ các request API hoặc từ bot
        if ($request->is('api/*') || $this->isBot($request->userAgent())) {
            return true;
        }

        // Trường hợp truy cập vào trang admin sẽ không bị loại trừ
        return false;
    }


    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isDesktop()) return 'Desktop';
        if ($agent->isTablet()) return 'Tablet';
        if ($agent->isMobile()) return 'Mobile';
        return 'Other';
    }

    private function isBot($userAgent): bool
    {
        $botKeywords = [
            'bot',
            'crawler',
            'spider',
            'slurp',
            'googlebot',
            'baidu',
            'bing',
            'yahoo',
            'yandex'
        ];

        $userAgent = strtolower($userAgent);
        return collect($botKeywords)->contains(function ($keyword) use ($userAgent) {
            return str_contains($userAgent, $keyword);
        });
    }
}
