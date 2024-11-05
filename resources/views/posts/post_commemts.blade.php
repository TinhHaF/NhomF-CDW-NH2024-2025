<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Comment Section
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <div class="max-w-[800px] mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">
            Bình Luận ({{ $comments->total() }})
        </h2>
        <form action="{{ route('comments_store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <textarea class="w-full p-3 border rounded-lg mb-4" name="content" placeholder="Chia sẻ ý kiến của bạn" rows="4" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6">
                Gửi bình luận
            </button>
        </form>
        <div class="border-b mb-4">
            <ul class="flex space-x-4 text-red-600">
                <li class="border-b-2 border-red-600 pb-2">
                    Mới nhất
                </li>
            </ul>
        </div>
        @foreach ($comments as $comment)
        <div class="flex items-start space-x-4">
            <img alt="User avatar" class="rounded-full mt-5" height="40" src="{{ asset('storage/' . $comment->user->image) }}" width="40" />
            <div>
                <div class="font-semibold">
                    {{ $comment->user->username }}
                </div>
                <div class="text-gray-700">
                    {{ $comment->content }}
                </div>
                <div class="flex items-center text-gray-500 text-sm mt-2 mb-5 space-x-4">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-thumbs-up">
                        </i>
                        <span>
                            Thích 14
                        </span>
                    </div>
                    <div>
                        Trả lời
                    </div>
                    <div>
                        {{ $comment->created_at->format('H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- Phân trang cho bình luận -->
        <div>
            {{ $comments->links() }}
        </div>
    </div>
</body>

</html>