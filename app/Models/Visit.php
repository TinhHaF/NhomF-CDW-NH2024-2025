<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Visit extends Model
{
    /**
     * Các trường có thể được gán hàng loạt
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
        'browser',
        'device_type',
        'visited_at',
        'page_url',
        'referrer',
        'session_id',
    ];

    /**
     * Các trường được cast sang kiểu khác
     */
    protected $casts = [
        'visited_at' => 'datetime',
    ];

    /**
     * Scopes cho các truy vấn phổ biến
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->where('visited_at', '>=', now()->startOfWeek());
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->where('visited_at', '>=', now()->startOfMonth());
    }

    public function scopeOnline(Builder $query): Builder
    {
        return $query->where('visited_at', '>=', now()->subMinutes(15));
    }

    /**
     * Accessors & Mutators
     */
    protected function browser(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    protected function deviceType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    /**
     * Ghi nhận một lượt truy cập mới
     */
    public static function track($request): self
    {
        $agent = new \Jenssegers\Agent\Agent();

        return static::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $agent->browser(),
            'device_type' => static::detectDeviceType($agent),
            'visited_at' => now(),
            'page_url' => url()->current(),
            'referrer' => $request->headers->get('referer'),
            'session_id' => session()->getId(),
        ]);
    }

    /**
     * Xác định loại thiết bị
     */
    protected static function detectDeviceType(\Jenssegers\Agent\Agent $agent): string
    {
        if ($agent->isDesktop()) return 'desktop';
        if ($agent->isTablet()) return 'tablet';
        if ($agent->isMobile()) return 'mobile';
        return 'other';
    }

    /**
     * Thống kê
     */
    public static function getStats(): array
    {
        return [
            'today' => static::today()->count(),
            'this_week' => static::thisWeek()->count(),
            'this_month' => static::thisMonth()->count(),
            'online' => static::online()->count(),
            'total' => static::count(),
        ];
    }

    public static function getBrowserStats(): array
    {
        return static::selectRaw('browser, COUNT(*) as count')
            ->groupBy('browser')
            ->get()
            ->mapWithKeys(fn($item) => [$item->browser => $item->count])
            ->toArray();
    }

    public static function getDeviceStats(): array
    {
        return static::selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->get()
            ->mapWithKeys(fn($item) => [$item->device_type => $item->count])
            ->toArray();
    }
}
