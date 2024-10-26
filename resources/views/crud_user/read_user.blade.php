<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-4 bg-white shadow-lg rounded-lg mt-10">
        <div class="flex justify-between items-center border-b pb-2 mb-4">
            <h1 class="text-xl font-bold">Thông Tin Tài Khoản</h1>
            <form action="{{  }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer hover:text-red-500 transition duration-300"></i>
                </button>
            </form>
        </div>
        <div class="flex">
            <div class="w-1/2 pr-4 border-r">
                <h2 class="text-lg font-bold mb-4">Thông tin chung</h2>
                <div class="mb-4">
                    <label class="block font-bold mb-2">Tên tài khoản:</label>
                    <div class="bg-gray-300 h-10 rounded-lg flex items-center pl-2">{{ $user->username }}</div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-2">Email đăng ký:</label>
                    <div class="bg-gray-300 h-10 rounded-lg flex items-center pl-2">{{ $user->email }}</div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-2">Mật khẩu:</label>
                    <div class="bg-gray-300 h-10 rounded-lg flex items-center pl-2">*******</div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-2">Ngày tham gia:</label>
                    <div class="bg-gray-300 h-10 rounded-lg flex items-center pl-2">
                        {{ $user->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            <div class="w-1/2 pl-4">
                <h2 class="text-lg font-bold mb-4">Tiện ích</h2>
                <div class="mb-4">
                    <a href="#" class="bg-gray-300 w-full py-2 rounded-lg hover:bg-gray-400 transition duration-300 text-center block">
                        Thay đổi mật khẩu
                    </a>
                </div>
                <div class="mb-4">
                    <form action="{{ }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gray-300 w-full py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                            Đăng Xuất Tài Khoản
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
