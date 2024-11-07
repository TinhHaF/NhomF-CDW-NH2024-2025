<body>
    @include('home.nav')
    @include('components.notifications')
    <div class="container mx-auto border border-gray-300 rounded-lg p-5 bg-gray-50 my-10 " style="width: 800px;">

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
        <div class="content">
            <div class="image text-center mb-5">
                <img alt="{{ $post->title }}" src="{{ asset('storage/' . $post->image) }}" class="max-w-full h-auto inline-block" />
            </div>
            <div class="category text-sm text-gray-600 mb-5">
                Danh Mục: {{ $post->category ? $post->category->name : 'Chưa có danh mục' }}
            </div>
            <p class="text-base mb-2">
                {!! $post->content !!}
            </p>
        </div>
    </div>
    @include('posts.post_commemts')
    @include('home.footer')
</body>