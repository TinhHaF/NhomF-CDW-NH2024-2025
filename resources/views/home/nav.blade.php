<div class="navbar flex items-center justify-between bg-gray-300 p-4">
    <div class="logo w-12 h-12 bg-white rounded-full flex items-center justify-center font-bold">
        Logo
    </div>
    <div class="search-container flex items-center">
        <div class="search-box flex items-center bg-gray-600 rounded-full px-4 py-2 text-white">
            <input type="text" placeholder="Tìm Kiếm" class="bg-transparent border-none outline-none text-white mr-2">
            <i class="fas fa-search"></i>
        </div>
    </div>
    @guest
    <div class="login flex items-center font-bold text-black">
        <a href="{{ route('user.login') }}" class="flex items-center">
            <i class="fas fa-user mr-2"></i>
            <span>Đăng nhập</span>
        </a>
    </div>
    @else
    <div class="login flex items-center font-bold text-black">
        <a href="{{ route('user.login') }}" class="flex items-center">
            <i class="fas fa-user mr-2"></i>
            <span>Đăng xuất</span>
        </a>
    </div>
    @endguest
</div>
