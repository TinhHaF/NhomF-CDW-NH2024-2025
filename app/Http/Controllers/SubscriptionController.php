<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        // Lưu thông tin email của người dùng vào cơ sở dữ liệu
        Subscriber::create([
            'email' => $request->email,
        ]);

        // Trả về phản hồi thành công
        return back()->with('success', 'Bạn đã đăng ký nhận tin thành công!');
    }
}
