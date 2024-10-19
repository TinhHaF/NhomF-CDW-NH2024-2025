<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    //hiện thị trang đăng ký
    public function registerUser()
    {
        return view('crud_user.register');
    }

    public function addUser(Request $request)
    {
        // Xác thực dữ liệu đầu vào với các quy tắc đặc biệt
        $request->validate([
            'username' => [
                'required', 
                'unique:users', 
                'regex:/^[a-zA-Z0-9]{6,20}$/'
            ],
            'email' => [
                'required', 
                'email', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]{6,30}@gmail\.com$/'
            ],
            'password' => [
                'required', 
                'min:6', 
                'max:20', 
                'regex:/^\S{6,20}$/'
            ],
        ], [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'username.unique' => 'Tên tài khoản hoặc email đã được sử dụng, vui lòng nhập tên khác.',
            'username.regex' => 'Tên đăng nhập lớn hơn 6 ký tự, không quá 20 ký tự (a-zA-Z0-9), không được chứa ký tự đặc biệt.',
            
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Tên tài khoản hoặc email đã được sử dụng, vui lòng nhập email khác.',
            'email.regex' => 'Email phải có đuôi là @gmail.com, có ít nhất 6 ký tự trước đuôi và tối đa 30 ký tự.',
            
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải lớn hơn 6 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
            'password.regex' => 'Mật khẩu không được bao gồm khoảng trắng.',
        ]);
    
        // Lấy dữ liệu từ request
        $data = $request->only(['username', 'email', 'password']);
    
        // Tạo người dùng mới
        User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Mã hóa mật khẩu
        ]);
    
        // Điều hướng về trang đăng nhập với thông báo thành công
        return redirect('login')->with('success', 'Tạo người dùng thành công.');
    }
    
    
}
