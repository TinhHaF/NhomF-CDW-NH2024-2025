@php
use App\Helpers\IdEncoder;
@endphp

<div class="container mx-auto ml-230 px-4">
    <nav class="flex space-x-6 py-3">
        <!-- Link Trang chủ -->
        <a href="{{ route('home') }}" aria-label="Trang chủ"
            class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
            <i class="fa-solid fa-house mr-2"></i>
            Trang chủ
        </a>

        <!-- Danh sách danh mục -->
        <div class="flex flex-wrap space-x-6">
            @foreach ($categories->take(15) as $category)
                <a href="{{ route('posts.showCate', IdEncoder::encode($category->id)) }}"
                    class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                    {{ $category->name }}
                </a>
            @endforeach

            <!-- Nếu có nhiều hơn 8 danh mục, hiển thị nút "3 gạch" -->
            @if ($categories->count() > 15)
                <button id="moreCategoriesButton" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">
                ☰
                </button>
            @endif
        </div>
    </nav>

    <!-- Dropdown chứa các danh mục còn lại -->
    <div id="moreCategoriesDropdown" class="hidden absolute mt-2 bg-white shadow-lg rounded-lg w-auto z-10">
        <ul class="flex flex-wrap  space-x-6 px-4 py-2">
            @foreach ($categories->skip(15) as $category)
                <li>
                    <a href="{{ route('posts.showCate', IdEncoder::encode($category->id)) }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    const moreCategoriesButton = document.getElementById('moreCategoriesButton');
    const moreCategoriesDropdown = document.getElementById('moreCategoriesDropdown');

    if (moreCategoriesButton) {
        moreCategoriesButton.addEventListener('click', () => {
            // Toggle hiển thị dropdown
            moreCategoriesDropdown.classList.toggle('hidden');
        });

        // Đảm bảo khi click ra ngoài sẽ đóng dropdown
        document.addEventListener('click', (e) => {
            if (!moreCategoriesButton.contains(e.target) && !moreCategoriesDropdown.contains(e.target)) {
                moreCategoriesDropdown.classList.add('hidden');
            }
        });
    }
</script>



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