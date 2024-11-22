<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'browser',
        'device_type',
        'visited_at',
        'page_url',
        'referrer',
        'session_id',
        'user_id',
        'is_anonymous'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'is_anonymous' => 'boolean'
    ];

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

    public function scopeAnonymous(Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }

    public function scopeAuthenticated(Builder $query): Builder
    {
        return $query->whereNotNull('user_id');
    }

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

    // Trong phương thức track()
    public static function track($request, $userId = null): self
    {
        $agent = new Agent();
        $sessionId = session()->getId();
        $pageUrl = url()->current();
        $ipAddress = $request->ip();

        // Kiểm tra trùng lặp dựa trên session, IP và khoảng thời gian
        $existingVisit = self::where('session_id', $sessionId)
            ->where('ip_address', $ipAddress)
            ->where('visited_at', '>=', now()->subMinutes(30))
            ->first();

        // Nếu không có lượt truy cập tương tự thì mới ghi nhận
        if (!$existingVisit) {
            return static::create([
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'browser' => $agent->browser(),
                'device_type' => static::detectDeviceType($agent),
                'visited_at' => now(),
                'page_url' => $pageUrl,
                'referrer' => $request->headers->get('referer'),
                'session_id' => $sessionId,
                'user_id' => $userId,
                'is_anonymous' => $userId === null,
            ]);
        }

        return $existingVisit;
    }

    // Sử dụng session timeout để theo dõi khi người dùng rời đi
    public static function trackOnlineStatus($request)
    {
        $sessionId = session()->getId();
        $lastVisit = session('last_visit', now());

        if ($lastVisit->diffInMinutes(now()) > 15) {
            // Người dùng không truy cập trong vòng 15 phút, nên đánh dấu offline
            self::where('session_id', $sessionId)
                ->update(['visited_at' => now()]);
        }

        // Cập nhật thời gian cuối cùng truy cập
        session(['last_visit' => now()]);
    }



    protected static function detectDeviceType(Agent $agent): string
    {
        if ($agent->isDesktop()) return 'desktop';
        if ($agent->isTablet()) return 'tablet';
        if ($agent->isMobile()) return 'mobile';
        return 'other';
    }

    public static function getStats(): array
    {
        return [
            'today' => static::today()->count(),
            'this_week' => static::thisWeek()->count(),
            'this_month' => static::thisMonth()->count(),
            'online' => static::online()->count(),
            'total' => static::count(),
            'anonymous' => static::anonymous()->count(),
            'authenticated' => static::authenticated()->count(),
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
