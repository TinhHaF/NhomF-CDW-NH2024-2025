    <html>

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

    <!-- Trong file chính của bạn -->
    <div class="max-w-[800px] mx-auto mt-10 bg-white p-6 rounded-lg shadow-md mb-10">
        <h2 class="text-xl font-semibold mb-4">
            Bình Luận ({{ $comments->total() }})
        </h2>
        <form action="{{ route('comments_store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <textarea class="w-full p-3 border rounded-lg mb-4" name="content" placeholder="Chia sẻ ý kiến của bạn" rows="4" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-6">Gửi bình luận</button>
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
            <img alt="User avatar" class="rounded-full mt-5" height="40" width="40" src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : 'https://example.com/macdinh.jpg' }}" width="40" />
            <div>
                <div class="flex flex-col space-y-2 p-4 border-b border-gray-300 bg-gray-50">
                    <div class="flex items-center space-x-2">
                        <div class="font-semibold text-sm text-gray-800">{{ $comment->user->username }}</div>
                    </div>
                    <div class="text-gray-800">{{ $comment->content }}</div>
                    <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                <!-- Cả nút Trả lời và Xóa trong một form -->
                <form action="{{ route('comments.user_delete', $comment->encoded_comment_id) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    @method('DELETE')
                    <button onclick="toggleReplyForm('{{ $comment->comment_id }}')" type="button" class="text-blue-500 hover:underline">
                        Trả lời
                    </button>
                    @if (Auth::id() === $comment->user_id)
                    <button type="submit" class="text-red-600 hover:text-red-800">
                        Xóa
                    </button>
                    @endif
                </form>


                <!-- Form trả lời ẩn -->
                <form id="reply-form-{{ $comment->comment_id }}" action="{{ route('comments_store', ['post' => $post->id]) }}" method="POST" class="hidden mt-4">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->comment_id }}">
                    <textarea class="w-full p-2 border rounded-lg mb-2" name="content" placeholder="Nhập trả lời của bạn" rows="2" required></textarea>
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg">Gửi trả lời</button>
                </form>

                <!-- Hiển thị các bình luận con -->
                @if ($comment->replies)
                <div class="mt-4 ml-8">
                    @foreach ($comment->replies as $reply)
                    @include('posts.comment_replies', ['reply' => $reply])
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Phân trang cho bình luận -->
        <div>
            {{ $comments->links() }}
        </div>
    </div>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            form.classList.toggle('hidden');
        }
    </script>




    </body>

    </html>