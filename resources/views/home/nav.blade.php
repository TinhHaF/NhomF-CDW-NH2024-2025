<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <style>
        .hover-scale {
            transition: transform 0.3s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .custom-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .slider-container {
            position: relative;
            height: 500px;
        }

        .slider-item {
            position: relative;
            height: 500px;
        }

        .slider-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 2rem;
            color: white;
        }

        .tns-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .tns-nav button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            margin: 0 4px;
            border: none;
        }

        .tns-nav button.tns-nav-active {
            background: white;
        }
    </style>
</head>
<div class="navbar bg-white border-b relative z-50">
    {{-- Header Ad --}}
    @if ($headerAd = App\Models\Ad::where('position', 'header')->where('status', 1)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first())
        <a href="{{ $headerAd->url }}">
            <img src="{{ asset('uploads/ads/' . $headerAd->image) }}" alt="{{ $headerAd->title }}">
        </a>
    @endif

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
                <a href="" class="hover:text-blue-200 transition-colors"><i class="fab fa-linkedin-in"></i></a>
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
                    <img src="{{ asset($logoPath) }}" alt="logo" id="logoPreview"
                        class="w-full h-full object-cover rounded-full">
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
                <div class="relative flex max-w-xl mt-4">
                    <div class="relative">
                        @include('home.search')
                    </div>
                </div>
            </div>

            <!-- User Section -->
            @php
                $user = Auth::user();
            @endphp
            <div class="mr-4">
            @include('home.notification')
            </div>
          
            @include('home.setting')
        </div>
    </div>

    <!-- Optional Navigation Menu -->
    <div class="border-t hidden md:block">
        @include('home.categories')
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
    });
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

    

    if (window.location.hash === '#_=_') {
        history.replaceState ?
            history.replaceState(null, null, window.location.href.split('#')[0]) :
            window.location.hash = '';
    }
</script>

</html>