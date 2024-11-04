<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Tài Khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-blue-50 to-green-50">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-xl rounded-lg mt-10 border-l-4 border-blue-400">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Thông Tin Tài Khoản</h1>
            <form action="{{ route('home') }}" method="GET">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300">
                    <i class="fas fa-sign-out-alt text-2xl"></i>
                </button>
            </form>
        </div>
        <div class="flex space-x-6">
            <div class="w-1/2 pr-4 border-r border-gray-300">
                <h2 class="text-2xl font-semibold mb-4 text-gray-700">Thông tin chung</h2>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Tên tài khoản:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">{{ $user->username }}</div>
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-1 text-gray-600">Email đăng ký:</label>
                    <div class="bg-gray-200 h-12 rounded-lg flex items-center pl-4 text-gray-700">{{ $user->email }}</div>
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
            <div class="w-1/2 pl-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-700">Tiện ích</h2>
                <div class="mb-4">
                    <form action="{{ route('user.change_show') }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white w-full py-3 rounded-lg hover:shadow-lg transition duration-300 text-center block font-semibold">
                            Thay đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
