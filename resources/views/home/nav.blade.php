<div class="navbar flex items-center justify-between bg-gradient-to-r from-gray-300 to-gray-400 p-4 shadow-lg relative">
    <!-- Logo -->
    <div class="logo w-12 h-12 bg-white rounded-full flex items-center justify-center font-bold text-lg text-gray-700">
        Logo
    </div>

    <!-- Search Box -->
    <div class="search-container flex items-center">
        <div class="search-box flex items-center bg-gray-700 rounded-full px-4 py-2 text-white">
            <input type="text" placeholder="Tìm Kiếm"
                class="bg-transparent border-none outline-none text-white mr-2 placeholder-gray-300">
            <i class="fas fa-search text-gray-300"></i>
        </div>
    </div>

    <!-- User Section -->
    @php
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    @endphp

    @guest
        <div class="login flex items-center font-bold text-black hover:text-red-500 transition duration-300">
            <a href="{{ route('login') }}" class="flex items-center">
                <i class="fas fa-user mr-2"></i>
                <span>Đăng nhập</span>
            </a>
        </div>
    @else
        <div class="login relative flex items-center font-bold text-gray-800 hover:text-red-500 transition duration-300">
            <a href="#" id="userMenuToggle" class="flex items-center space-x-2">
                <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                    class="w-10 h-10 rounded-full border-2 border-gray-300">
                <span>{{ $user->username }}</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div id="userMenu"
                class="absolute right-0 mt-12 w-56 bg-white border border-gray-300 rounded-lg shadow-lg hidden z-50 transition-all duration-300 ease-out transform scale-95">
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

    <!-- JavaScript for Dropdown Menu -->
    <script>
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userMenu = document.getElementById('userMenu');

        // Toggle dropdown menu visibility with smooth transition
        userMenuToggle.addEventListener('click', function (event) {
            event.preventDefault();
            userMenu.classList.toggle('hidden');

            if (!userMenu.classList.contains('hidden')) {
                userMenu.classList.remove('opacity-0', 'scale-95');
                userMenu.classList.add('opacity-100', 'scale-100');
            } else {
                userMenu.classList.remove('opacity-100', 'scale-100');
                userMenu.classList.add('opacity-0', 'scale-95');
            }
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target) && !userMenuToggle.contains(event.target)) {
                userMenu.classList.add('hidden', 'opacity-0', 'scale-95');
            }
        });
    </script>
    <script>
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userMenu = document.getElementById('userMenu');

        // Toggle dropdown menu visibility with smooth transition
        userMenuToggle.addEventListener('click', function (event) {
            event.preventDefault();
            userMenu.classList.toggle('hidden');

            if (!userMenu.classList.contains('hidden')) {
                userMenu.classList.remove('opacity-0', 'scale-95');
                userMenu.classList.add('opacity-100', 'scale-100');
            } else {
                userMenu.classList.remove('opacity-100', 'scale-100');
                userMenu.classList.add('opacity-0', 'scale-95');
            }
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target) && !userMenuToggle.contains(event.target)) {
                userMenu.classList.add('hidden', 'opacity-0', 'scale-95');
            }
        });
    </script>
</div>