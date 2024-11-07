<?php

namespace App\Providers;

use App\Services\VisitorTrackingService;
use Illuminate\Support\ServiceProvider;

class VisitorTrackingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(VisitorTrackingService::class, function ($app) {
            return new VisitorTrackingService();
        });
    }
}