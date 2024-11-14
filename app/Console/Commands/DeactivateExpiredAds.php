<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Illuminate\Console\Command;

class DeactivateExpiredAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:deactivate-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vô hiệu hóa các quảng cáo đã hết hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tìm và cập nhật các quảng cáo đã hết hạn
        $expiredAds = Ad::where('end_date', '<', now())
            ->where('status', 1)
            ->update(['status' => 0]);

        $this->info("Vô hiệu hóa $expiredAds quảng cáo đã hết hạn.");
    }
    // Đặt lịch trình cho command này
    public function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
    {
        $schedule->command('ads:deactivate-expired')->daily(); // Chạy mỗi ngày
    }
}
