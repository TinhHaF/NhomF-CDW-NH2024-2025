<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Bài Viết Đã Lưu</title>
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.2);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex flex-col min-h-screen">
        @include('home.nav')

        <!-- Header Section -->
        <div class="gradient-bg py-12 mb-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Bài Viết Đã Lưu</h1>
                <p class="text-gray-100 text-lg">Danh sách những bài viết bạn đã đánh dấu để đọc sau</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            @if ($savedPosts->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <div class="mb-4">
                        <i class="fas fa-bookmark text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có bài viết nào được lưu</h3>
                    <p class="text-gray-600 mb-6">Hãy lưu những bài viết yêu thích để đọc sau nhé!</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <i class="fas fa-home mr-2"></i> Khám phá bài viết
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($savedPosts as $post)
                        <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                            class="card-hover bg-white rounded-xl overflow-hidden">
                            <!-- Card Image -->
                            @if ($post->image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover"
                                        alt="{{ $post->title }}">
                                </div>
                            @endif
                            <!-- Card Content -->
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <span
                                        class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-full">
                                        {{ $post->category->name ?? 'Chung' }}
                                    </span>
                                    <span class="ml-auto text-sm text-gray-500">
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                    {{ $post->title }}
                                </h2>

                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->content), 150) }}
                                </p>

                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <span class="ml-2 text-sm font-medium text-gray-900">
                                        Tác Giả: {{ $post->author->pen_name ?? 'Chưa có tác giả' }}
                                        </span>
                                    </div>
                                    <div class="ml-auto flex items-center text-sm text-gray-500">
                                        <i class="far fa-eye mr-1"></i>
                                        {{ $post->view ?? 0 }}
                                        <i class="far fa-comment ml-4 mr-1"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $savedPosts->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

        @include('home.footer')
    </div>
</body>

</html>