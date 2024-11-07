<?php

namespace App\Http\Middleware;

use App\Services\VisitorTrackingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    protected $visitorService;

    public function __construct(VisitorTrackingService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // $isAdmin = str_starts_with($request->path(), 'admin');
        $this->visitorService->trackVisit($request);
        
        return $next($request);
    }
}