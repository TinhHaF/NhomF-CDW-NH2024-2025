<div class="flex items-start space-x-4">
    <img alt="User avatar" class="rounded-full mt-5"height="40" width="40" src="{{ $reply->user->image ? asset('storage/' . $reply->user->image) : 'https://example.com/macdinh.jpg' }}" width="40" />
    <div>
        <div class="font-semibold">{{ $reply->user->username }}</div>
        <div class="text-gray-700">{{ $reply->content }}</div>

        <!-- Nút trả lời và Xóa nằm ngang -->
        <div class="flex items-center text-gray-500 text-sm mb-5 space-x-4">
            <button onclick="toggleReplyForm('{{ $reply->comment_id }}')" class="text-blue-500 hover:underline">
                Trả lời
            </button>
            @if (Auth::id() === $reply->user_id)
                <form action="{{ route('comments.user_delete', $reply->encoded_comment_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 mt-3">Xóa</button>
                </form>
            @endif
        </div>

        <!-- Form trả lời ẩn -->
        <form id="reply-form-{{ $reply->comment_id }}" action="{{ route('comments_store', ['post' => $post->id]) }}" method="POST" class="hidden mt-4">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $reply->comment_id }}">
            <textarea class="w-full p-2 border rounded-lg mb-2" name="content" placeholder="Nhập trả lời của bạn" rows="2" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg">Gửi trả lời</button>
        </form>

        <!-- Đệ quy hiển thị các bình luận con -->
        @if ($reply->replies)
            <div class="ml-8 mt-4">
                @foreach ($reply->replies as $nestedReply)
                    @include('posts.comment_replies', ['reply' => $nestedReply])
                @endforeach
            </div>
        @endif
    </div>
</div>
