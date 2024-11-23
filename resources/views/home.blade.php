<style></style>
<title>Trang Chủ</title>
<body class="bg-gray-100">
    <div class="flex flex-col">
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
                                    <p class="text-gray-200 mb-4">{{ Str::limit(strip_tags($slide->content), 150) }}
                                    </p>
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
                    <x-ad-banner position="content" />

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
                                                    <span>{{$post->created_at->diffForHumans()}}</span>
                                                </div>
                                                <h3
                                                    class="text-2xl font-semibold mb-3 text-gray-800 hover:text-blue-600 transition duration-300">
                                                    {{ $post->title }}
                                                </h3>
                                                <p class="text-gray-600 leading-relaxed mb-4">
                                                    {!! Str::limit(strip_tags($post->content), 200) !!}
                                                </p>

                                                <div class="flex items-center">
                                                    <p class="text-sm text-gray-500">
                                                        Tác Giả: {{ $post->author->pen_name ?? 'Chưa có tác giả' }}
                                                    </p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var slider = tns({
                container: '.my-slider',
                items: 1,
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                controls: false,
                nav: true,
                autoplayTimeout: 5000,
                speed: 400,
            });
        });

        if (window.location.hash === '#_=_') {
            history.replaceState ?
                history.replaceState(null, null, window.location.href.split('#')[0]) :
                window.location.hash = '';
        }

    </script>

</body>