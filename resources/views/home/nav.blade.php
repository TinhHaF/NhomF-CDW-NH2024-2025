<style>
    /* Back to top */
    #backToTop {
        background: linear-gradient(45deg, #82da85, #81c784);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 50;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    #backToTop.show {
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    #backToTop.hidden {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
    }

    #backToTop:hover {
        background: linear-gradient(45deg, #388e3c, #66bb6a);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
</style>

<body>
    <div class="navbar bg-white border-b relative z-50">
        {{-- Header Ad --}}
        <x-ad-banner position="header" class="ad-banner-effect" />

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
                    <a href="#" class="hover:text-blue-200 transition-colors"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-blue-200 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-blue-200 transition-colors"><i
                            class="fab fa-linkedin-in"></i></a>
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
                    <div class="relative flex max-w-xl">
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
    </div>

    <!-- Optional Navigation Menu -->
    <div class="border-t hidden md:block">
        @include('home.categories')
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

        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('backToTop');

            // Hiển thị nút khi cuộn trang xuống dưới 300px
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopButton.classList.remove('hidden');
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                    backToTopButton.classList.add('hidden');
                }
            });

            // Cuộn lên đầu trang khi nhấn nút
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const categoriesMenu = document.querySelector('.border-t.hidden.md\\:block');
            const navbar = document.querySelector('.navbar');

            // Create a placeholder div to prevent layout shift
            const placeholder = document.createElement('div');
            placeholder.style.display = 'none';
            placeholder.style.height = '0px';
            categoriesMenu.parentNode.insertBefore(placeholder, categoriesMenu);

            // Add transition and animation classes
            categoriesMenu.style.transition = 'all 0.3s ease-in-out';

            window.addEventListener('scroll', function() {
                const navbarHeight = navbar.offsetHeight;

                if (window.scrollY > navbarHeight) {
                    // Make categories menu fixed and visible with animation
                    categoriesMenu.classList.remove('hidden');
                    categoriesMenu.style.position = 'fixed';
                    categoriesMenu.style.top = '0';
                    categoriesMenu.style.left = '0';
                    categoriesMenu.style.width = '100%';
                    categoriesMenu.style.zIndex = '40';
                    categoriesMenu.style.backgroundColor = 'white';
                    categoriesMenu.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                    categoriesMenu.classList.add('p-2');

                    // Show the placeholder to maintain layout
                    placeholder.style.display = 'block';
                    placeholder.style.height = `${categoriesMenu.offsetHeight}px`;
                } else {
                    // Always keep it visible, just adjust positioning
                    categoriesMenu.classList.remove('hidden');
                    categoriesMenu.style.position = 'static';
                    categoriesMenu.style.width = '100%';
                    categoriesMenu.style.backgroundColor = 'white';
                    categoriesMenu.style.boxShadow = 'none';
                    categoriesMenu.classList.remove('p-2');

                    // Hide the placeholder
                    placeholder.style.display = 'none';
                    placeholder.style.height = '0px';
                }
            });

            // Optional: Add hover effect to categories
            const categoryLinks = categoriesMenu.querySelectorAll('a');
            categoryLinks.forEach(link => {
                link.style.transition = 'all 0.2s ease';
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.color = 'blue'; // Use standard color instead of Tailwind class
                });
                link.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.color = ''; // Reset to default
                });
            });
        });
    </script>
    <button id="backToTop"
        class="hidden fixed bottom-6 right-6 p-2 rounded shadow-lg transition-transform transform hover:scale-110 focus:outline-none">
        <i class="fas fa-arrow-up text-white text-lg"></i>
    </button>
</body>
