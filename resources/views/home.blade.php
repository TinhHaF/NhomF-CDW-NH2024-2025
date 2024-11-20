<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        @include('home.nav')



        <!-- Slider Section -->
        <div class="slider-container mb-8">
            <div class="my-slider">
                @if (isset($featuredPosts) && $featuredPosts->count())
                    @foreach ($featuredPosts->take(5) as $slide)
                        <div class="slider-item">
                            <img src="{{ asset('storage/' . $slide->image) }}" class="w-full h-full object-cover"
                                alt="{{ $slide->title }}">
                            <div class="slider-content">
                                <div class="container mx-auto">
                                    <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm mb-4 inline-block">
                                        Nổi bật
                                    </span>
                                    <h2 class="text-3xl font-bold mb-2">{{ $slide->title }}</h2>
                                    <p class="text-gray-200 mb-4">{{ Str::limit(strip_tags($slide->content), 150) }}</p>
                                    <a href="{{ route('posts.post_detail', ['id' => $slide->id, 'slug' => $slide->slug]) }}"
                                        class="bg-white text-gray-900 px-6 py-2 rounded-full inline-block hover:bg-gray-100 transition duration-300">
                                        Đọc thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Content -->
                <div class="lg:w-2/3">
                    {{-- Content Ad --}}
                    @if ($contentAd = App\Models\Ad::where('position', 'content')->where('status', 1)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first())
                        <a href="{{ $contentAd->url }}">
                            <img src="{{ asset('uploads/ads/' . $contentAd->image) }}" alt="{{ $contentAd->title }}">
                        </a>
                    @endif

                    <!-- Tin Mới Nhất -->
                    <div class="mb-12">
                        <div class="flex items-center mb-8">
                            <div class="w-1 h-8 bg-blue-500 mr-3"></div>
                            <h2 class="text-3xl font-bold text-gray-800">Tin Mới Nhất</h2>
                        </div>

                        @if (isset($posts) && $posts->count())
                            @foreach ($posts as $post)
                                <div class="bg-white rounded-xl custom-shadow hover-scale mb-6">
                                    <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="block">
                                        <div class="flex flex-col md:flex-row">
                                            @if ($post->image)
                                                <div class="md:w-2/5">
                                                    <img src="{{ asset('storage/' . $post->image) }}"
                                                        class="w-full h-64 md:h-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-t-none"
                                                        alt="{{ $post->title }}">
                                                </div>
                                            @endif
                                            <div class="md:w-3/5 p-6">
                                                <div class="flex items-center mb-3 text-sm text-gray-500">
                                                    <i class="far fa-calendar-alt mr-2"></i>
                                                    <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                                    <span class="mx-2">•</span>
                                                    <i class="far fa-clock mr-2"></i>
                                                    <span>5 phút đọc</span>
                                                </div>
                                                <h3
                                                    class="text-2xl font-semibold mb-3 text-gray-800 hover:text-blue-600 transition duration-300">
                                                    {{ $post->title }}
                                                </h3>
                                                <p class="text-gray-600 leading-relaxed mb-4">
                                                    {!! Str::limit(strip_tags($post->content), 200) !!}
                                                </p>
                                                <div class="flex items-center">
                                                    <img src="https://via.placeholder.com/40"
                                                        class="w-10 h-10 rounded-full mr-3" alt="Author">
                                                    <div>
                                                        <p class="font-medium text-gray-800">Tác giả</p>
                                                        <p class="text-sm text-gray-500">Quản trị viên</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Right Sidebar -->
                <!-- Sidebar -->
                @include('home.sidebar')
            </div>
        </div>

        @include('home.footer')
    </div>
</body>