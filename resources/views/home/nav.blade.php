<div class="navbar flex items-center justify-between bg-gray-300 p-4 relative">
    <div class="logo w-12 h-12 bg-white rounded-full flex items-center justify-center font-bold">
        Logo
    </div>
    <div class="search-container flex items-center">
        <div class="search-box flex items-center bg-gray-600 rounded-full px-4 py-2 text-white">
            <input type="text" placeholder="Tìm Kiếm" class="bg-transparent border-none outline-none text-white mr-2">
            <i class="fas fa-search"></i>
        </div>
    </div>
    @php
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    @endphp
    @guest
        <div class="login flex items-center font-bold text-black">
            <a href="{{ route('login') }}" class="flex items-center">
                <i class="fas fa-user mr-2"></i>
                <span>Đăng nhập</span>
            </a>
        </div>
    @else
        <div class="login relative flex items-center font-bold text-black">
            <a href="#" id="userMenuToggle" class="flex items-center">
            <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
            class="w-10 h-10 rounded-full border">
                <span>{{ $user->username }}</span>
            </a>
            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg hidden z-10">
                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Thông Tin Tài Khoản</a>
                <a href="{{ route('user.logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Đăng Xuất</a>
            </div>
        </div>
    @endguest
    <script>
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userMenu = document.getElementById('userMenu');
        userMenuToggle.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            userMenu.classList.toggle('hidden'); // Hiện/ẩn menu
        });
        // Đóng menu khi nhấp ra ngoài
        window.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target) && !userMenuToggle.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</div>
