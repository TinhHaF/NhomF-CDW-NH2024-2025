<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-8">
    @include('components.notifications')

    <div class="container mx-auto px-4 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

        @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-64 object-cover rounded-lg mb-4" alt="{{ $post->title }}">
        @endif

        <p class="text-gray-500 mb-4">Ngày đăng: {{ $post->created_at->format('d/m/Y') }}</p>

        <div class="text-gray-700 mb-6">
            <p>{!! $post->content !!}</p>
        </div>

        <!-- Hiển thị form bình luận -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-4">Bình luận</h2>

            <form action="{{ route('post.comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="content" class="w-full h-24 p-2 border rounded" placeholder="Nhập bình luận của bạn..." required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 mt-2 text-white px-4 py-2 rounded">
                    Gửi bình luận
                </button>
            </form>

            <!-- Hiển thị danh sách bình luận -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold">Ý Kiến:</h3>
                @foreach ($post->comments->reverse() as $comment)
                <div class="comment mb-4 p-4 border rounded">
                    <p><strong>{{ $comment->user->username }}</strong></p>
                    <p class="text-gray-500">{{ $comment->created_at->format('H:i:s') }}</p>
                    <p>{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Trở về danh sách bài viết</a>
        </div>
    </div>
</body>

</html>