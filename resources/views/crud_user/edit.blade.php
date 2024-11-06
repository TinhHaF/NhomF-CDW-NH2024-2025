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
                    <label for="username" class="block font-bold mb-2">Tên Người Dùng:</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('username')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật Khẩu -->
                <div class="mb-4">
                    <label for="password" class="block font-bold mb-2">Mật Khẩu Mới (để trống nếu không thay đổi):</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Xác Nhận Mật Khẩu -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block font-bold mb-2">Xác Nhận Mật Khẩu:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Ảnh Đại Diện -->
                <div class="mb-4">
                    <label for="image" class="block font-bold mb-2">Hình Đại Diện:</label>
                    <input type="file" name="image" id="image"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar" class="w-24 h-24 mt-2 rounded-full border">
                    @endif
                </div>

                <!-- Nút Cập Nhật -->
                <div class="mb-4">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                        Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
