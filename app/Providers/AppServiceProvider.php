<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\VisitorTrackingService;
use Illuminate\Support\Facades\View;
use App\Models\Logo;
use App\Models\Notification;
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
        View::composer('*', function ($view) {
            $notifications = Notification::orderBy('created_at', 'desc')->get();
            $unreadCount = Notification::where('read', false)->count();
    
            $view->with([
                'notifications' => $notifications,
                'unreadCount' => $unreadCount,
            ]);
        });
    }
}
