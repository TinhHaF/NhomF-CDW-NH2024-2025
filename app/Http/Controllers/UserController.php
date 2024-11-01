<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    //hiện thị trang đăng ký
    public function registerUser()
    {
        return view('crud_user.register');
    }
    //Hiện thị trang đăng nhập
    public function login()
    {
        return view('crud_user.login');
    }
    public function home()
    {
        return view('home');
    }
    public function detail_user()
    {
        return view('crud_user.read_user');
    }
    public function change_user_password()
    {
        return view('crud_user.change_password');
    }
    //Hàm đăng ký tài khoản
    public function addUser(Request $request)
    {
        // Xác thực dữ liệu đầu vào
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
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'username.unique' => 'Tên tài khoản hoặc email đã được sử dụng, vui lòng nhập tên khác.',
            'username.regex' => 'Tên đăng nhập phải có 6-20 ký tự và không chứa ký tự đặc biệt.',
    
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Tên tài khoản hoặc email đã được sử dụng, vui lòng nhập email khác.',
            'email.regex' => 'Email phải có đuôi @gmail.com, với tối thiểu 6 ký tự và tối đa 30 ký tự trước đuôi.',
    
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải lớn hơn 6 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
            'password.regex' => 'Mật khẩu không được chứa khoảng trắng.',
            
            'image.image' => 'Avatar phải là ảnh hợp lệ.',
            'image.mimes' => 'Avatar phải có định dạng jpg, jpeg hoặc png.',
            'image.max' => 'Avatar không được vượt quá 2MB.',
        ]);
    
        // Lưu ảnh hoặc dùng ảnh mặc định
        $imagePath = $request->file('image')
            ? $request->file('image')->store('avatars', 'public')
            : 'avatars/default.png'; // Ảnh mặc định
    
        // Tạo người dùng mới
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
            'image' => $imagePath,
        ]);
    
        // Điều hướng về trang đăng nhập với thông báo thành công
        return redirect('/login')->with('success', 'Tạo người dùng thành công.');
    }
    //Đăng Nhập
    public function loginUser(Request $request)
    {
        // Tạo khóa duy nhất cho người dùng dựa trên IP và username
        $throttleKey = 'login:' . $request->ip() . '|' . $request->input('username');

        // Kiểm tra nếu người dùng đã vượt quá số lần thử đăng nhập
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            // Trả về thông báo tùy chỉnh nếu vượt quá giới hạn
            return redirect('login')->withErrors([
                'throttle' => "Tài khoản của bạn đã bị khóa do thử đăng nhập không thành công quá nhiều lần. Vui lòng thử lại sau $seconds giây.",
            ]);
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ]);

        $credentials = $request->only('username', 'password');

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            // Xóa số lần thử đăng nhập khi đăng nhập thành công
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            // Kiểm tra role của người dùng
            if ($user->role == 1) {
                return redirect()->intended('/')->withSuccess('Đăng nhập thành công.');
            } elseif ($user->role == 2 || $user->role == 3) {
                return redirect()->intended('admin/dashboard')->withSuccess('Đăng nhập thành công.');
            }

            // Nếu role không hợp lệ, đăng xuất người dùng
            Auth::logout();
            return redirect('login')->withErrors([
                'role' => 'Vai trò của tài khoản không hợp lệ.',
            ]);
        }

        // Tăng số lần thử đăng nhập khi đăng nhập không thành công
        RateLimiter::hit($throttleKey, 60); // Thời gian khóa là 60 giây

        // Tính số lần đăng nhập còn lại
        $attempts = RateLimiter::attempts($throttleKey);
        $maxAttempts = 3; // Giới hạn số lần thử đăng nhập
        $remainingAttempts = $maxAttempts - $attempts;

        // Trả về thông báo với số lần thử còn lại
        return redirect('login')
            ->withErrors([
                'credentials' => 'Thông tin tài khoản hoặc mật khẩu không chính xác. Số lần thử còn lại: ' . max(0, $remainingAttempts),
            ])
            ->withInput(); // Giữ lại dữ liệu đã nhập
    }
    public function getUserInfo()
{
    if (Auth::check()) {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('crud_user.read_user', compact('user')); // Truyền dữ liệu sang view
    }
    
    return redirect('login')->withErrors([
        'auth' => 'Bạn cần đăng nhập để xem thông tin tài khoản.',
    ]);
}
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/login');
    }
    public function changePassword(Request $request)
    {
        // 1. Xác thực dữ liệu từ form
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|max:20|confirmed',
        ]);
    
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    
        // 2. Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }
    
        // 3. Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // 4. Trả về thông báo thành công
        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

}
