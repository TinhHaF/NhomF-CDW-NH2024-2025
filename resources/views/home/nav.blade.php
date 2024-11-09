<div class="navbar bg-white border-b relative z-50">
    <!-- Top Bar - Optional -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-1 px-4 text-sm hidden md:block">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="mailto:contact@example.com" class="hover:text-blue-200 transition-colors flex items-center">
                    <i class="far fa-envelope mr-2"></i>contact@example.com
                </a>
                <a href="tel:+84123456789" class="hover:text-blue-200 transition-colors flex items-center">
                    <i class="far fa-phone-alt mr-2"></i>+84 123 456 789
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-blue-200 transition-colors"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-blue-200 transition-colors"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-blue-200 transition-colors"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <!-- Logo Section -->
            <div class="flex items-center space-x-2">
                <div
                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold shadow-lg transform hover:scale-105 transition-transform duration-200">
                    <img src="{{ asset($logoPath) }}"
                        alt="logo" id="logoPreview" class="w-full h-full object-cover rounded-full">
                </div>

                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-gray-800">Group F</h1>
                    <p class="text-sm text-gray-500">Professional Solutions</p>
                </div>
            </div>

            <!-- Center Section with Date and Search -->
            <div class="flex-1 px-6 flex items-center justify-center space-x-6">
                <!-- Date Display -->
                <div class="hidden lg:flex items-center text-gray-600 font-medium">
                    <i class="far fa-calendar-alt mr-2 text-blue-600"></i>
                    <span id="currentDate" class="text-sm"></span>
                </div>
                <!-- Search Bar -->
                <div class="relative flex-1 max-w-xl">
                    <div class="relative">
                        <form action="{{ route('posts.search') }}" method="GET" class="flex items-center">

                            <input type="text" name="query" placeholder="Tìm kiếm..."
                                class="w-full px-4 py-2 pl-10 pr-12 rounded-full border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-gray-600 text-sm">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-1.5 rounded-full hover:bg-blue-700 transition-colors duration-200">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User Section -->
            @php
                $user = Auth::user();
            @endphp
            @guest
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 font-medium">
                        <i class="fas fa-user"></i>
                        <span>Đăng nhập</span>
                    </a>
                </div>
            @else
                <div
                    class="login relative flex items-center font-bold text-gray-800 hover:text-red-500 transition duration-300">
                    <a href="#" id="userMenuToggle" class="flex items-center space-x-2">
                        <div class="flex flex-col items-start">
                            <span class="text-sm font-medium text-gray-700">{{ $user->username }}</span>
                            <span class="text-xs text-gray-500">{{ $user->email }}</span>
                        </div>
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                            class="w-10 h-10 rounded-full border-2 border-gray-300">
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
        </div>
    </div>

    <!-- Optional Navigation Menu -->
    <div class="border-t hidden md:block">
        <div class="container mx-auto px-4">
            <nav class="flex space-x-6 py-3">
                @foreach ($categories as $category)
                    <a href="{{ route('category.show', $category->id) }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiển thị ngày hiện tại
        function formatDate() {
            const today = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('currentDate').textContent = today.toLocaleDateString('vi-VN', options);
        }
        formatDate();

        // // Xử lý thanh tìm kiếm
        // const searchInput = document.querySelector('input[type="text"]');
        // searchInput.addEventListener('focus', function() {
        //     this.parentElement.classList.add('ring-2', 'ring-blue-200');
        // });

        // searchInput.addEventListener('blur', function() {
        //     this.parentElement.classList.remove('ring-2', 'ring-blue-200');
        // });

        // // Mobile menu toggle (nếu cần)
        // const mobileMenuBtn = document.querySelector('#mobile-menu-btn');
        // if (mobileMenuBtn) {
        //     mobileMenuBtn.addEventListener('click', function() {
        //         document.querySelector('#mobile-menu').classList.toggle('hidden');
        //     });
        // }
    });
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userMenu = document.getElementById('userMenu');

    // Toggle dropdown menu visibility with smooth transition
    userMenuToggle.addEventListener('click', function(event) {
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
    window.addEventListener('click', function(event) {
        if (!userMenu.contains(event.target) && !userMenuToggle.contains(event.target)) {
            userMenu.classList.add('hidden', 'opacity-0', 'scale-95');
        }
    });
</script>
