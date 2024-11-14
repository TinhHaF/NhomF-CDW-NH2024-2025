<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\VisitorTrackingService;
use Illuminate\Support\Facades\View;
use App\Models\Logo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(VisitorTrackingService::class, function ($app) {
            return new VisitorTrackingService();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind(); // Nếu bạn muốn sử dụng Bootstrap
    }
}
