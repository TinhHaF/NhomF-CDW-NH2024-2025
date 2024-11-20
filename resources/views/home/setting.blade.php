@guest
    <div class="flex items-center space-x-4">
        <a href="{{ route('login') }}"
            class="flex items-center space-x-2 px-4 py-2 rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 font-medium">
            <i class="fas fa-user"></i>
            <span>Đăng nhập</span>
        </a>
    </div>
@else
    <div class="login relative flex items-center font-bold text-gray-800 hover:text-red-500 transition duration-300">
        <a href="#" id="userMenuToggle" class="flex items-center space-x-2">
            <div class="flex flex-col items-start">
                <span class="text-sm font-medium text-gray-700">{{ $user->username }}</span>
                <span class="text-xs text-gray-500">{{ $user->email }}</span>
            </div>
            @if($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                    class="w-10 h-10 rounded-full border-2 border-gray-300">
            @else
                <img src="{{ asset('user_avt/avt.jpg') }}" alt="Avatar"
                    class="w-10 h-10 rounded-full border-2 border-gray-300">
            @endif
            <i class="fas fa-caret-down"></i>
        </a>

        <div id="userMenu"
    class="absolute right-0 mt-72 w-56 bg-white border border-gray-300 rounded-lg shadow-lg hidden z-50 transition-all duration-300 ease-out transform scale-95">
    <div class="p-4">
        <a href="{{ route('user.profile') }}"
            class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-user-circle text-blue-500 mr-3"></i>
            <span>Thông Tin Tài Khoản</span>
        </a>

        @if (Auth::user()->role == 2 || Auth::user()->role == 3)
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition mt-2">
                <i class="fas fa-cogs text-green-500 mr-3"></i>
                <span>Quản lý</span>
            </a>
        @endif
        <a href="{{ route('user.logout') }}"
            class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition mt-2">
            <i class="fas fa-sign-out-alt text-red-500 mr-3"></i>
            <span>Đăng Xuất</span>
        </a>
    </div>
</div>
    </div>
@endguest
