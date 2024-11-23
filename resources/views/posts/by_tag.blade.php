<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Viết Theo Tag</title>
</head>

@include('home.nav')

<body class="bg-gradient-to-br min-h-screen">
    @include('components.notifications')

    <div class="container mx-auto px-4 max-w-6xl py-12">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 flex items-center justify-center gap-3">
                <i class="fas fa-tag text-blue-600 text-3xl"></i>
                Bài viết liên quan đến:
                <span class="text-blue-600">{{ $tag->name }}</span>
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Khám phá bộ sưu tập các bài viết được gắn thẻ với "{{ $tag->name }}"
            </p>
        </div>

        <!-- Posts Grid -->
        @if ($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div
                        class="bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-3 group">
                        <!-- Post Image -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ isset($post->image) && file_exists(public_path('storage/' . $post->image)) ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        </div>

                        <!-- Post Content -->
                        <div class="p-6">
                            <h2
                                class="text-xl font-semibold text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                            </h2>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </p>

                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-calendar-alt text-blue-500 mr-2"></i>
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10 flex justify-center space-x-4">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        @else
            <!-- No Posts -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg max-w-xl mx-auto text-center">
                <p class="text-yellow-700 font-medium text-lg">
                    Không có bài viết nào liên quan đến tag này.
                </p>
            </div>
        @endif
    </div>

    @include('home.footer')
</body>

</html>