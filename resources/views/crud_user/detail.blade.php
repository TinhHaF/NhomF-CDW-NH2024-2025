@extends('admin.layout')
@section('content')

<body>
    <div class="m-6">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700">Bảng điều
                        khiển</a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-700">Quản lý Người
                        dùng</a>
                </li>
                <li>/</li>
                <li class="text-gray-700">Chi Tiết Người Dùng</li>
            </ol>
        </nav>

        <!-- Profile Card -->
        <div
            class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden transition transform hover:scale-105 hover:shadow-xl duration-300">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8 flex items-center justify-between">
                <div class="flex items-center">


                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="User Avatar"
                            class="w-24 h-24 rounded-full border-4 border-white shadow-md">
                    @else
                        <img src="{{ asset('user_avt/avt.jpg') }}" alt="User Avatar"
                            class="w-24 h-24 rounded-full border-4 border-white shadow-md">
                    @endif


                    <div class="ml-6">
                        <h2 class="text-white text-4xl font-bold mb-1">{{ $user->username }}</h2>
                        <p class="text-blue-200">{{ $user->email }}</p>
                        <span
                            class="mt-2 inline-block bg-blue-700 text-white px-3 py-1 rounded-full text-xs font-semibold uppercase">{{ $user->role }}</span>
                    </div>
                </div>
            </div>

            <!-- Personal Details and Stats -->
            <div class="p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Thông Tin Cá Nhân</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="p-4 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <p class="text-sm font-semibold text-gray-500">Email:</p>
                        <p class="text-lg font-medium text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <p class="text-sm font-semibold text-gray-500">Ngày Tạo:</p>
                        <p class="text-lg font-medium text-gray-800">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <p class="text-sm font-semibold text-gray-500">Vai Trò:</p>
                        <p class="text-lg font-medium text-gray-800">
                            @if ($user->role == 1)
                                Người dùng
                            @elseif ($user->role == 2)
                                Quản trị viên
                            @elseif ($user->role == 3)
                                Tác giả
                            @else
                                Không xác định
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection