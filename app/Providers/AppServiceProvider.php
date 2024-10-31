<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; 
use App\Services\UserStatsService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(UserStatsService::class, function ($app) {
            return new UserStatsService();
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
