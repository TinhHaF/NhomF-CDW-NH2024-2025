<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        function toggleChangePasswordForm() {
            const form = document.getElementById('change-password-form');
            form.classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gradient-to-r from-indigo-100 to-teal-100">
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg mt-10 border-l-4 border-indigo-500">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-4xl font-bold text-gray-800">Thông Tin Tài Khoản</h1>
            <form action="{{ route('home') }}" method="GET">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300">
                    <i class="fas fa-sign-out-alt text-2xl"></i>
                </button>
            </form>
        </div>

        <!-- Avatar -->
        <div class="flex flex-col items-center mb-8">
            <form action="{{ route('user.update_avatar') }}" method="POST" enctype="multipart/form-data"
                class="w-full max-w-xs">
                @csrf
                <div class="mb-4 text-center">
                    <label class="block font-bold mb-1 text-gray-600">Avatar:</label>
                    <div class="flex justify-center">
                        <div class="relative">
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                                    class="w-32 h-32 rounded-full border border-gray-300 object-cover mb-2 transition duration-300 transform hover:scale-110 shadow-lg">
                            @else
                                <img src="{{ asset('user_avt/avt.jpg') }}" alt="Avatar"
                                    class="w-32 h-32 rounded-full border border-gray-300 object-cover mb-2 transition duration-300 transform hover:scale-110 shadow-lg">
                            @endif
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" required>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm">Nhấn vào ảnh để thay đổi avatar.</p>
                </div>
                <button type="submit"
                    class="bg-indigo-500 text-white rounded-lg px-4 py-2 w-full hover:bg-indigo-600 transition duration-300">Cập
                    nhật Avatar</button>
            </form>
        </div>

        <div class="flex space-x-6">
            <div class="w-1/2 pr-4 border-r border-gray-300">
                <h2 class="text-3xl font-semibold mb-4 text-gray-700">Thông tin chung</h2>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Tên tài khoản:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">{{ $user->username }}
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Email đăng ký:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">{{ $user->email }}
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Mật khẩu:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">*******</div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Ngày tham gia:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">
                        {{ $user->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <!-- Tiện ích -->
            <div class="w-1/2 pl-6">
                <div class="bg-gray-100 p-4 rounded-lg shadow mb-4">
                    <h2 class="text-3xl font-semibold mb-4 text-gray-700">Tiện ích</h2>
                    <div class="mb-4">
                        <button onclick="toggleChangePasswordForm()"
                            class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white w-full py-3 rounded-lg hover:shadow-lg transition duration-300 text-center block font-semibold">
                            Thay đổi mật khẩu
                        </button>
                    </div>
                    @php
                        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
                    @endphp
                    @if (Auth::user()->role == 1)
                        <div class="mb-4">
                            <button onclick="window.location.href='{{ asset('/register-author-show') }}'"
                                class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white w-full py-3 rounded-lg hover:shadow-lg transition duration-300 text-center block font-semibold">
                                Đăng Ký Tác giả
                            </button>
                        </div>
                    @endif
                </div>

                <div id="change-password-form" class="hidden bg-white p-6 rounded-lg shadow-lg mt-4">
                    <h2 class="text-lg font-bold mb-4">Thay đổi mật khẩu</h2>

                    <!-- Hiển thị thông báo lỗi -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center mb-2">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Hiển thị thông báo thành công -->
                    @if (session('success'))
                        <div class="bg-green-100 text-green-600 p-4 rounded mb-4">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('user.change_pw') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Mật khẩu hiện tại:</label>
                            <input type="password" name="current_password"
                                class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Mật khẩu mới:</label>
                            <input type="password" name="new_password"
                                class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Xác nhận mật khẩu mới:</label>
                            <input type="password" name="new_password_confirmation"
                                class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        <div class="mb-4">
                            <button type="submit"
                                class="bg-indigo-500 text-white w-full py-2 rounded-lg hover:bg-indigo-600 transition duration-300">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>