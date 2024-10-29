<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-4">
        <div class="flex justify-between items-center border-b pb-2 mb-4">
            <h1 class="text-xl font-bold">Thay Đổi Mật Khẩu</h1>
            <form action="{{ route('user.profile') }}" method="GET">
                <button type="submit">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer hover:text-red-500 transition duration-300"></i>
                </button>
            </form>
        </div>

        <div class="flex justify-center">
            <div class="w-1/2 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-bold mb-4">Thay đổi mật khẩu</h2>

                <!-- Hiển thị thông báo lỗi -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Hiển thị thông báo thành công -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-600 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.change_pw') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Mật khẩu hiện tại:</label>
                        <input type="password" name="current_password"
                            class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Mật khẩu mới:</label>
                        <input type="password" name="new_password"
                            class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Xác nhận mật khẩu mới:</label>
                        <input type="password" name="new_password_confirmation"
                            class="bg-gray-200 w-full h-10 px-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div class="mb-4">
                        <button type="submit"
                            class="bg-blue-500 text-white w-full py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
