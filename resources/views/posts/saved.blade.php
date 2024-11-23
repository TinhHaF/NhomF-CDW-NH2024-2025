<!DOCTYPE html>
<html lang="vi">

<head>
    {{--
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 150) }}" />
    <meta property="og:image" content="{{ asset('storage/' . $post->image) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="My Blog" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $post->title }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->content), 150) }}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $post->image) }}" />
    <meta name="twitter:site" content="@YourTwitterHandle" /> --}}


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

<body class="bg-gray-100">
    <div class="flex flex-col">
        @include('home.nav')
        <!-- Slider Section -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Danh sách bài viết đã lưu</h1>

            @if ($savedPosts->isEmpty())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">Bạn chưa lưu bài viết nào.</span>
            </div>
            @else
            <div class="space-y-4">
                @foreach ($savedPosts as $post)
                <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                    class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h2>
                    <p class="text-gray-600 mt-2">{{ Str::limit($post->content, 100) }}</p>
                    <div class="text-sm text-gray-500 mt-4">
                        <span>Đăng bởi: <strong>{{ $post->author->name ?? 'Không rõ' }}</strong></span>
                        <span class="ml-4">Ngày: {{ $post->created_at->format('d/m/Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Hiển thị phân trang -->
            <div class="mt-6">
                {{ $savedPosts->links('pagination::tailwind') }}
            </div>
            @endif

        </div>
    </div>
</body>

@include('home.footer')


<script>
    if (window.location.hash === '#_=_') {
        history.replaceState ?
            history.replaceState(null, null, window.location.href.split('#')[0]) :
            window.location.hash = '';
    }
</script>

</body>