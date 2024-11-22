<?php

namespace App\View\Components;

use App\Models\Ad;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdBanner extends Component
{
    public $ads;

    /**
     * Create a new component instance.
     */
    public function __construct($position)
    {
        // Lấy tất cả quảng cáo có cùng vị trí và còn hiệu lực
        $this->ads = Ad::where('position', $position)
            ->where('status', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();  // Đây là một Collection (mảng kiểu đối tượng)

        // Nếu không có quảng cáo, gán $ads là mảng rỗng
        if ($this->ads->isEmpty()) {
            $this->ads = [];  // Gán mảng rỗng thay vì null
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ad-banner');
    }
}
