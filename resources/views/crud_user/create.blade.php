@extends('admin.layout')
@section('content')

<body>
    <div class="m-6">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700">Bảng điều khiển</a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-700">Quản lý Người dùng</a>
                </li>
                <li>/</li>
                <li>Thêm Người Dùng</li>
            </ol>
        </nav>

        <!-- Page Title -->
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Thêm Người Dùng Mới</h2>

        <!-- Success and Error Messages -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 transition-transform transform hover:scale-105 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4 transition-transform transform hover:scale-105 shadow-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- User Form -->
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-200 ease-in-out transform hover:-translate-y-1">
            <form action="{{ route('user.storeUser') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="mb-6">
                    <label for="username" class="block text-lg font-semibold text-gray-700 mb-2">Tên Người Dùng</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required value="{{ old('username') }}">
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required value="{{ old('email') }}">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-lg font-semibold text-gray-700 mb-2">Mật Khẩu</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-lg font-semibold text-gray-700 mb-2">Xác Nhận Mật Khẩu</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required>
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-lg font-semibold text-gray-700 mb-2">Vai Trò</label>
                    <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required>
                        <option value="" disabled selected>Chọn vai trò</option>
                        <option value="1">Người dùng</option>
                        <option value="2">Quản trị viên</option>
                        <option value="3">Tác giả</option>
                    </select>
                </div>

                <!-- Avatar Upload -->
                <div class="mb-6">
                    <label for="avatar" class="block text-lg font-semibold text-gray-700 mb-2">Avatar</label>
                    <input type="file" id="avatar" name="avatar" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transform hover:-translate-y-1 hover:scale-105 transition-all duration-200">
                        Thêm Người Dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
