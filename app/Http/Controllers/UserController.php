<?php

namespace App\Http\Controllers;
use App\Helpers\IdEncoder;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
    public function store_user()
    {
        return view('crud_user.create');
    }
    public function show($id)
    {
        $user = User::findOrFail($id); // Retrieve the user by ID or throw a 404 if not found
        return view('crud_user.detail', compact('user')); // Pass $user to the view
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
            ? $request->file('image')->store('avatars', 'public') // Lưu ảnh vào thư mục 'avatars' trong disk 'public'
            : null; // Không có ảnh, gán giá trị null

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

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ]);

        $credentials = $request->only('username', 'password');

        // Kiểm tra xem tài khoản có tồn tại hay không
        $userExists = User::where('username', $request->input('username'))->exists();
        if (!$userExists) {
            return redirect('login')->withErrors([
                'username' => 'Tên người dùng không tồn tại.',
            ])->withInput();
        }

        // Kiểm tra nếu người dùng đã vượt quá số lần thử đăng nhập
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            // Trả về thông báo tùy chỉnh nếu vượt quá giới hạn
            return redirect('login')->withErrors([
                'throttle' => "Tài khoản của bạn đã bị khóa do thử đăng nhập không thành công quá nhiều lần. Vui lòng thử lại sau $seconds giây.",
            ]);
        }

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
        return Redirect('/');
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

    public function index(Request $request)
    {
        // Lấy danh sách người dùng từ bảng `users`, kèm theo tìm kiếm nếu cần
        $users = User::query();

        if ($request->has('search')) {
            $users->where('username', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Thêm phân trang, mỗi trang hiển thị 10 người dùng
        $users = $users->paginate(5);

        // Trả về view và truyền dữ liệu người dùng vào
        return view('crud_user.index', compact('users'));
    }
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => [
                'required',
                'unique:users', // Kiểm tra tính duy nhất của tên người dùng
                'regex:/^[a-zA-Z0-9]{6,20}$/' // Tên đăng nhập phải có 6-20 ký tự và không chứa ký tự đặc biệt
            ],
            'email' => [
                'required',
                'email', // Đảm bảo định dạng email hợp lệ
                'unique:users', // Kiểm tra tính duy nhất của email
                'regex:/^[a-zA-Z0-9._%+-]{6,30}@gmail\.com$/' // Email phải có đuôi @gmail.com, tối thiểu 6 ký tự trước đuôi
            ],
            'password' => [
                'required',
                'min:6', // Mật khẩu phải có ít nhất 6 ký tự
                'max:20', // Mật khẩu không được vượt quá 20 ký tự
                'regex:/^\S{6,20}$/' // Mật khẩu không được chứa khoảng trắng
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Avatar phải là ảnh hợp lệ
            'role' => 'required|string|max:1', // Yêu cầu nhập vai trò
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

            'avatar.image' => 'Avatar phải là ảnh hợp lệ.',
            'avatar.mimes' => 'Avatar phải có định dạng jpg, jpeg, png, hoặc gif.',
            'avatar.max' => 'Avatar không được vượt quá 2MB.',

            'role.required' => 'Vai trò là bắt buộc.',
            'role.max' => 'Vai trò không hợp lệ.',
        ]);

        // Kiểm tra vai trò hợp lệ (1 - User, 2 - Admin, 3 - Author)
        $role = $request->input('role');
        if (!in_array($role, [1, 2, 3])) {
            return redirect()->back()->withErrors(['role' => 'Vai trò không hợp lệ.'])->withInput();
        }

        // Lưu ảnh hoặc dùng ảnh mặc định
        $imagePath = $request->file('avatar')
            ? $request->file('avatar')->store('avatars', 'public')
            : null; // Ảnh mặc định

        // Tạo người dùng mới
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Lưu vai trò người dùng
            'image' => $imagePath, // Lưu đường dẫn ảnh avatar
        ]);

        // Chuyển hướng về trang danh sách người dùng kèm thông báo thành công
        return redirect()->route('users.index')->with('success', 'Người dùng mới đã được thêm thành công!');
    }

    public function destroy($id)
{
    // Giải mã ID trước khi tìm kiếm người dùng
    $decodedId = IdEncoder::decode($id);

    // Kiểm tra nếu ID giải mã không hợp lệ
    if (!$decodedId) {
        return redirect()->route('users.index')->with('error', 'ID không hợp lệ!');
    }

    // Tìm người dùng theo ID đã giải mã
    $user = User::find($decodedId);

    // Kiểm tra nếu không tìm thấy người dùng
    if (!$user) {
        return redirect()->route('users.index')->with('error', 'Người dùng không tồn tại!');
    }

    // Xóa tất cả các bình luận của người dùng
    $user->comments()->delete();

    // Xóa ảnh đại diện nếu có
    if ($user->image) {
        Storage::disk('public')->delete($user->image);
    }

    // Xóa người dùng
    $user->delete();

    // Chuyển hướng với thông báo thành công
    return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
}



    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        // Xác thực ảnh tải lên
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Giới hạn kích thước và định dạng ảnh
        ]);

        // Xóa avatar cũ nếu có
        if ($user->image && Storage::exists($user->image)) {
            Storage::delete($user->image);
        }

        // Lưu image mới
        $path = $request->file('image')->store('images', 'public');
        $user->image = $path; // Cập nhật cột 'image'
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật hình ảnh thành công!');
    }


    public function edit($encodedId)
{
    // Giải mã ID
    $id = IdEncoder::decode($encodedId);

    // Tìm người dùng bằng ID đã giải mã
    $user = User::findOrFail($id);

    // Trả về view với người dùng
    return view('crud_user.edit', compact('user'));
}
    
    

public function update(Request $request, $id)
{
    // Giải mã ID
    $decodedId = IdEncoder::decode($id);

    // Xác thực dữ liệu đầu vào
    $request->validate([
        'username' => [
            'required',
            'string',
            'max:255',
            'regex:/^[a-zA-Z0-9]{6,20}$/' // Tên đăng nhập phải có 6-20 ký tự và không chứa ký tự đặc biệt
        ],
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email,' . $decodedId, // Đảm bảo email là duy nhất ngoại trừ người dùng hiện tại
            'regex:/^[a-zA-Z0-9._%+-]{6,30}@gmail\.com$/' // Email phải có đuôi @gmail.com
        ],
        'password' => [
            'nullable',
            'string',
            'min:6', // Mật khẩu phải có ít nhất 6 ký tự
            'max:20',
            'regex:/^\S{6,20}$/' // Mật khẩu không được chứa khoảng trắng
        ],
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Kiểm tra ảnh đại diện nếu có
        'role' => 'required|in:1,2,3', // Kiểm tra vai trò hợp lệ
    ], [
        'username.required' => 'Tên người dùng là bắt buộc.',
        'username.regex' => 'Tên đăng nhập phải có 6-20 ký tự và không chứa ký tự đặc biệt.',

        'email.required' => 'Email là bắt buộc.',
        'email.email' => 'Email không hợp lệ.',
        'email.unique' => 'Email đã được sử dụng.',
        'email.regex' => 'Email phải có đuôi @gmail.com, với tối thiểu 6 ký tự và tối đa 30 ký tự trước đuôi.',

        'password.min' => 'Mật khẩu phải lớn hơn 6 ký tự.',
        'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
        'password.regex' => 'Mật khẩu không được chứa khoảng trắng.',

        'image.image' => 'Avatar phải là ảnh hợp lệ.',
        'image.mimes' => 'Avatar phải có định dạng jpg, jpeg, png, hoặc gif.',
        'image.max' => 'Avatar không được vượt quá 2MB.',

        'role.required' => 'Vai trò là bắt buộc.',
        'role.in' => 'Vai trò không hợp lệ.',
    ]);

    // Cập nhật thông tin người dùng
    $user = User::findOrFail($decodedId);
    $user->username = $request->username;
    $user->email = $request->email;
    $user->role = $request->role; // Cập nhật vai trò

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password); // Mã hóa mật khẩu
    }

    // Xử lý hình ảnh
    if ($request->hasFile('image')) {
        // Xóa hình ảnh cũ nếu có
        if ($user->image) {
            Storage::delete('public/' . $user->image);
        }
        $user->image = $request->file('image')->store('avatars', 'public'); // Lưu hình ảnh mới
    }

    $user->save(); // Lưu thông tin người dùng

    return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
}

}
