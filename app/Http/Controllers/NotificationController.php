<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Logo;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
class NotificationController extends Controller
{
    public function index()
    {
        // Lấy tất cả thông báo từ bảng notifications
        $notifications = Notification::all();

        // Trả về view và truyền dữ liệu notifications
        return view('home.notification', compact('notifications'));
    }
}
