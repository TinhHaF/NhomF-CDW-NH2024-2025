<footer class="bg-gradient-to-r from-white-200 to-gray-900 text-black-200 pt-12 pb-8 border-t border-gray-300 shadow-lg">
    <div class="container mx-auto px-4">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- About Section -->
            <div class="col-span-1">
                <h5 class="font-bold text-xl text-black mb-4">Về Chúng Tôi</h5>
                <div class="mb-4">
                    <img src="/logo.png" alt="Logo" class="h-12 mb-4">
                    <p class="text-gray-400 leading-relaxed mb-4">
                        Chúng tôi cung cấp những thông tin hữu ích và đáng tin cậy nhất về công nghệ,
                        giúp bạn luôn cập nhật với xu hướng mới nhất.
                    </p>
                </div>
                <!-- Social Media Icons -->
                <div class="flex space-x-4">
                    <a href="#" class="hover:-translate-y-1 transition-transform duration-200">
                        <i
                            class="fab fa-facebook-f bg-blue-600 text-white p-2 rounded-full w-8 h-8 flex items-center justify-center"></i>
                    </a>
                    <a href="#" class="hover:-translate-y-1 transition-transform duration-200">
                        <i
                            class="fab fa-twitter bg-blue-400 text-white p-2 rounded-full w-8 h-8 flex items-center justify-center"></i>
                    </a>
                    <a href="#" class="hover:-translate-y-1 transition-transform duration-200">
                        <i
                            class="fab fa-tiktok bg-black text-white p-2 rounded-full w-8 h-8 flex items-center justify-center"></i>
                    </a>
                    <a href="#" class="hover:-translate-y-1 transition-transform duration-200">
                        <i
                            class="fab fa-youtube bg-red-600 text-white p-2 rounded-full w-8 h-8 flex items-center justify-center"></i>
                    </a>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="col-span-1">
                <h5 class="font-bold text-xl text-black mb-4">Danh Mục</h5>
                <ul class="space-y-3">
                    {{-- @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('category.show', $category->category_id) }}"
                                class="text-gray-400 hover:text-black hover:pl-2 transition-all duration-200 flex items-center">
                                <i class="fas fa-chevron-right mr-2 text-sm"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach --}}
                </ul>
            </div>

            <!-- Featured Posts Section -->
            <div class="col-span-1">
                <h5 class="font-bold text-xl text-black mb-4">Tin Nổi Bật</h5>
                <ul class="space-y-4">
                    @if (isset($featuredPosts))
                        <ul>
                            @foreach ($featuredPosts as $post)
                                <li>
                                    <a
                                        href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </ul>
            </div>

            <!-- Contact Info Section -->
            <div class="col-span-1">
                <h5 class="font-bold text-xl text-black mb-4">Liên Hệ</h5>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt w-6 text-blue-500"></i>
                        <span>123 Đường ABC, Quận XYZ, TP.HCM</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt w-6 text-blue-500"></i>
                        <span>+84 123 456 789</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope w-6 text-blue-500"></i>
                        <span>contact@example.com</span>
                    </li>
                </ul>

                <!-- Newsletter Subscription -->
                <div class="mt-6">
                    <h6 class="text-black font-semibold mb-3">Đăng ký nhận tin</h6>
                    <form class="flex">
                        <input type="email" placeholder="Email của bạn"
                            class="bg-gray-700 text-gray-300 px-4 py-2 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 flex-grow">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r transition-colors duration-200">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-200 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <!-- Copyright -->
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} Group F. Tất cả quyền được bảo lưu.
                </div>
                <!-- Quick Links -->
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-black text-sm transition-colors duration-200">
                        Điều khoản sử dụng
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black text-sm transition-colors duration-200">
                        Chính sách bảo mật
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black text-sm transition-colors duration-200">
                        Giới thiệu
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black text-sm transition-colors duration-200">
                        Liên hệ
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
