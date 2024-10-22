<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-8">

    <div class="container mx-auto px-4 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

        @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-64 object-cover rounded-lg mb-4" alt="{{ $post->title }}">
        @endif

        <p class="text-gray-500 mb-4">Ngày đăng: {{ $post->created_at->format('d/m/Y H:i') }}</p> <!-- Hiển thị ngày đăng -->

        <div class="text-gray-700">
            <p>{{ $post->content }}</p>
        </div>
    </div>

    <div class="mt-4 flex justify-center">
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Trở về danh sách bài viết</a>
    </div>

</body>

</html>
