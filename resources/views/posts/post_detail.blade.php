<body class="">
    @include('home.nav')
    @include('components.notifications')
    <div class="container mx-auto border border-gray-300 p-5 bg-gray-50 mt-10" style="width: 800px;">

        <div class="text-2xl font-bold mb-2">
            {{ $post->title }}
        </div>
        <div class="flex justify-between text-sm text-gray-600 mb-5">
            <div class="date">
                {{ $post->created_at->format('d/m/Y H:i') }} (GMT+7)
            </div>
            <div class="author">
                Tác giả: {{ $post->author->pen_name ?? 'Chưa có tác giả' }}
            </div>
        </div>
        <div class="text-sm text-gray-600 mb-5">
            Lượt xem: {{ $post->view }}
        </div>

        <div class="content">
            <div class="image text-center mb-5">
                <img alt="{{ $post->title }}" src="{{ asset('storage/' . $post->image) }}"
                    class="max-w-full h-auto inline-block" />
            </div>
            <div class="category text-sm text-gray-600 mb-5">
                Danh Mục: {{ $post->category ? $post->category->name : 'Chưa có danh mục' }}
            </div>
            <p class="text-base mb-2">
                {!! $post->content !!}
            </p>
            <!-- Share Buttons -->
            <div class="mt-6">
                <span class="text-gray-700 font-semibold">Chia sẻ bài viết:</span>
                <div class="flex items-center space-x-4 mt-3">
                    <!-- Facebook Share -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&t={{ urlencode($post->title) }}"
                        target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-200">
                        <i class="fab fa-facebook-f w-4 h-4 flex items-center justify-center"></i>
                    </a>
                    <!-- Twitter Share -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                        target="_blank"
                        class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition-all duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <!-- Pinterest Share -->
                    <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ asset('storage/' . $post->image) }}&description={{ urlencode($post->title) }}"
                        target="_blank"
                        class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-full shadow-lg transition-all duration-200">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    @include('posts.post_commemts')
    @include('home.footer')
</body>
