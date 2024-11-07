@extends('admin.layout')

@section('content')

<body>
    <div class="m-4">
        <h1 class="text-2xl font-bold mb-6">Cập Nhật Người Dùng</h1>

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tên Người Dùng -->
                <div class="mb-4">
                    <label for="username" class="block text-lg font-semibold text-gray-700 mb-2">Tên Người Dùng:</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('username')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-lg font-semibold text-gray-700 mb-2">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    @error('email')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật Khẩu -->
                <div class="mb-4">
                    <label for="password" class="block text-lg font-semibold text-gray-700 mb-2">Mật Khẩu Mới (để trống nếu không thay
                        đổi):</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Xác Nhận Mật Khẩu -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-lg font-semibold text-gray-700 mb-2">Xác Nhận Mật Khẩu:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Vai Trò -->
                <div class="mb-6">
                    <label for="role" class="block text-lg font-semibold text-gray-700 mb-2">Vai Trò</label>
                    <select id="role" name="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                        required>
                        <option value="" disabled>Chọn vai trò</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Người dùng</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Quản trị viên</option>
                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Tác giả</option>
                    </select>
                </div>

                <!-- Ảnh Đại Diện -->
                <div class="mb-4">
                    <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Hình Đại Diện:</label>
                    <input type="file" name="image" id="image"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                            class="w-24 h-24 mt-2 rounded-full border">
                    @endif
                </div>

                <!-- Nút Cập Nhật -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transform hover:-translate-y-1 hover:scale-105 transition-all duration-200">
                        Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection