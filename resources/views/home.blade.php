<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-8">
    
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6">Tin Đề Xuất</h2> 

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md">
                <h5 class="text-lg font-semibold p-4">
                <a href="{{ route('posts.show', \App\Http\Controllers\PostController::encodeId($post->id)) }}" class="hover:underline">{{ $post->title }}</a>

                </h5>
                <div class="flex">
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-1/2 h-48 object-cover rounded-l-lg ml-1 mb-1" alt="{{ $post->title }}">
                    @endif
                    <div class="p-4 w-1/2">
                        <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Phân trang -->
    <div class="mt-4">
        {{ $posts->links() }} <!-- Hiển thị các nút phân trang -->
    </div>
</div>
</body>

</html>
