<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <style>
        .hover-scale {
            transition: transform 0.3s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .custom-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .slider-container {
            position: relative;
            height: 500px;
        }

        .slider-item {
            position: relative;
            height: 500px;
        }

        .slider-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 2rem;
            color: white;
        }

        .tns-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .tns-nav button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            margin: 0 4px;
            border: none;
        }

        .tns-nav button.tns-nav-active {
            background: white;
        }
    </style>
</head>
@include('home.nav')

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
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
                    <div class="mb-12">
                        @if ($posts->isEmpty())
                            <div class="text-center text-gray-500 py-10">
                                <p>Không có bài viết nào.</p>
                            </div>
                        @else
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


                        <!-- Phân trang phía dưới -->
                        <div class="pagination mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
                <!-- Right Sidebar -->
                @include('home.sidebar')
            </div>
        </div>
    </div>
    @include('home.footer')
</body>

</html>
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

</html>