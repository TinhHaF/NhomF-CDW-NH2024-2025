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
                    class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center text-white font-bold shadow-lg transform hover:scale-105 transition-transform duration-200">
                    Logo
                </div>
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-gray-800">Your Brand</h1>
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
                        <input type="text" placeholder="Tìm kiếm..."
                            class="w-full px-4 py-2 pl-10 pr-12 rounded-full border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-gray-600 text-sm">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-1.5 rounded-full hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
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
                    <a href="{{ route('register') }}"
                        class="hidden md:flex items-center space-x-2 px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 font-medium">
                        <i class="fas fa-user-plus"></i>
                        <span>Đăng ký</span>
                    </a>
                </div>
            @else
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none">
                        <div class="flex flex-col items-end">
                            <span class="text-sm font-medium text-gray-700">{{ $user->username }}</span>
                            <span class="text-xs text-gray-500">{{ $user->email }}</span>
                        </div>
                        <img src="{{ asset($user->image) }}" alt="Profile"
                            class="w-10 h-10 rounded-full border-2 border-gray-200 group-hover:border-blue-500 transition-colors duration-200 object-cover">
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                        <div class="p-4 border-b">
                            <p class="text-sm font-medium text-gray-600">Đã đăng nhập với</p>
                            <p class="text-sm text-gray-800 font-bold truncate">{{ $user->email }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('user.profile') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-user-circle text-gray-600"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Hồ sơ của tôi</p>
                                    <p class="text-xs text-gray-500">Quản lý thông tin cá nhân</p>
                                </div>
                            </a>
                            {{-- <a href="{{ route('user.settings') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-cog text-gray-600"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Cài đặt</p>
                                    <p class="text-xs text-gray-500">Quản lý tài khoản</p>
                                </div>
                            </a> --}}
                            <a href="{{ route('user.logout') }}"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-50 text-red-600 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="text-sm font-medium">Đăng xuất</span>
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
                <a href="#"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Trang chủ</a>
                <a href="#"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Tin tức</a>
                <a href="#"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Sản phẩm</a>
                <a href="#"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Dịch vụ</a>
                <a href="#"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">Liên hệ</a>
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

        // Xử lý thanh tìm kiếm
        const searchInput = document.querySelector('input[type="text"]');
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-200');
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-200');
        });

        // Mobile menu toggle (nếu cần)
        const mobileMenuBtn = document.querySelector('#mobile-menu-btn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                document.querySelector('#mobile-menu').classList.toggle('hidden');
            });
        }
    });
</script>
