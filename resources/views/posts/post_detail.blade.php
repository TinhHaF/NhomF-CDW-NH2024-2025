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
                    <span>Tác giả: {{ $post->author->pen_name ?? 'Chưa có tác giả' }}</span>
                </div>
                <div class="content">
                    <div class="image text-center mb-5">
                        <img alt="{{ $post->title }}" src="{{ asset('storage/' . $post->image) }}" class="rounded-lg shadow-md max-w-full h-auto inline-block" />
                    </div>
                    <div class="category text-sm text-gray-500 mb-4">
                        Danh Mục: {{ $post->category ? $post->category->name : 'Chưa có danh mục' }}
                    </div>
                    <div class="text-base text-gray-700 leading-relaxed">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
            @include('posts.post_commemts')
        </div>
        <!-- Related Posts -->
        <div class="lg:w-2/5 w-full">
            @include('posts.sidebar_postscate')
        </div>
    </div>
    @include('home.footer')
</body>