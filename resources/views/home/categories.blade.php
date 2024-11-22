<div class="container mx-auto px-4">
    <nav class="flex space-x-6 py-3">
        <!-- Link Trang chủ -->
        <a href="{{ route('home') }}" aria-label="Trang chủ"
            class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-house mr-2"></i>
            Trang chủ
        </a>

        <!-- Danh sách danh mục -->
        @foreach ($categories as $category)
        <a href="{{ route('posts.showCate', $category->id) }}"
            class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
            {{ $category->name }}
        </a>
        @endforeach
    </nav>
</div>


<!-- Hiển thị menu trên thiết bị di động -->
<div class="md:hidden block">
    <div class="container mx-auto px-4">
        <button id="mobile-menu-toggle" class="text-gray-600 hover:text-blue-600">
            <i class="fa-solid fa-bars"></i>
        </button>
        <nav id="mobile-menu" class="hidden flex-col space-y-3 mt-3">
            <a href="{{ route('home') }}" aria-label="Trang chủ"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                <i class="fa-solid fa-house mr-2"></i>
                Trang chủ
            </a>

            @foreach ($categories as $category)
            <a href="{{ route('posts.showCate', $category->id) }}"
                class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                {{ $category->name }}
            </a>
            @endforeach
        </nav>
    </div>
</div>
<script>
    // Xử lý menu di động
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>