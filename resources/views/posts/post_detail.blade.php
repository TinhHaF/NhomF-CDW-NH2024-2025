<body class="bg-gray-100">
    @include('home.nav')
    @include('components.notifications')
    <div class="flex flex-col lg:flex-row justify-center gap-6 px-5 py-10">
        <!-- Main Content -->
        <div class="lg:w-3/5 w-full">
            <div class="container mx-auto border border-gray-300 rounded-lg p-6 bg-white " style="max-width: 720px;">
                <h1 class="text-2xl font-bold mb-4 text-gray-800">
                    {{ $post->title }}
                </h1>
                <div class="flex justify-between text-sm text-gray-500 mb-5">
                    <span>{{ $post->created_at->format('d/m/Y H:i') }} (GMT+7)</span>
                    <span>Tác giả:
                        <!-- Thêm liên kết vào tên tác giả -->
                        <a href="{{ route('authors.show', ['authorId' => Hashids::encode($post->author->id)]) }}"
                            class="text-gray-800 hover:text-blue-600 transition-colors font-medium">
                            {{ $post->author->pen_name ?? 'Chưa có tác giả' }}
                        </a>

                    </span>
                    <div class="flex items-center gap-3">
                        <img src="{{ $post->author->avatar ?? '/images/default-avatar.png' }}"
                            alt="{{ $post->author->name }}" class="w-10 h-10 rounded-full">
                        <div>
                            <a href="{{ route('authors.show', $post->author->id) }}"
                                class="text-gray-800 hover:text-blue-600 transition-colors font-medium">
                                {{ $post->author->name }}
                            </a>
                            <p class="text-gray-600 text-sm">{{ $post->author->role }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-sm text-gray-600 mb-5">
                    Lượt xem: {{ $post->view }}
                </div>
                <div class="content">
                    <div class="image text-center mb-5">
                        <img alt="{{ $post->title }}" src="{{ asset('storage/' . $post->image) }}"
                            class="rounded-lg shadow-md max-w-full h-auto inline-block" />
                    </div>
                    <div class="category text-sm text-gray-500 mb-4">
                        Danh Mục: {{ $post->category ? $post->category->name : 'Chưa có danh mục' }}
                    </div>
                    <div class="text-base text-gray-700 leading-relaxed">
                        {!! $post->content !!}
                    </div>
                </div>
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
                <div class="mt-4">
                    <form id="savePostForm" action="{{ route('posts.save', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-200">
                            <i class="fas fa-bookmark mr-2"></i> Lưu bài viết
                        </button>
                    </form>
                </div>
            </div>
            @include('posts.post_commemts')
        </div>
        <div class="lg:w-2/5 w-full">
            @include('posts.sidebar_postscate')
        </div>
    </div>
    @include('home.footer')
</body>