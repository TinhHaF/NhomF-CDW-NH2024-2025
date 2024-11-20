<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <!-- Phần tiêu đề -->
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Quên Mật Khẩu?</h2>

        <!-- Hiển thị thông báo thành công -->
        @if (session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
            {{ session('status') }}
        </div>
        @endif

        <!-- Form Quên Mật Khẩu -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Input Email -->
            <div class="mb-4">
                <label for="email" class="text-lg text-gray-700 font-semibold">Địa Chỉ Email</label>
                <input id="email" type="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                    name="email" value="{{ old('email') }}" required autofocus placeholder="Nhập email của bạn">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nút Gửi Liên Kết Đặt Lại Mật Khẩu -->
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Gửi Liên Kết Đặt Lại Mật Khẩu
                </button>
            </div>

            <!-- Liên kết Quay lại Đăng Nhập -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Quay lại trang Đăng Nhập</a>
            </div>
        </form>
    </div>
</body>

</html>
