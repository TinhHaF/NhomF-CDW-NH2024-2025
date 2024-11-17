<div class="flex items-start space-x-4 {{ $depth < 3 ? 'ml-' . ($depth * 4) : '' }}">
    <div>
        <!-- Phần thông tin bình luận -->
        <div class="flex space-x-4 p-4 border-b border-gray-300 bg-gray-50">
            <div class="flex-shrink-0">
                <img
                    alt="User avatar"
                    class="rounded-full object-cover"
                    height="40"
                    width="40"
                    src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : 'https://example.com/macdinh.jpg' }}"
                />
            </div>
            <div class="flex flex-col justify-start">
                <div class="font-semibold text-sm text-gray-800">{{ $comment->user->username }}</div>
                <div class="text-gray-800">{{ $comment->content }}</div>
                <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
        </div>

        <!-- Nút Trả lời và số lượng bình luận con -->
        <form action="{{ route('comments.user_delete', $comment->encoded_comment_id) }}" method="POST" class="flex items-center space-x-4 mt-2">
            @csrf
            @method('DELETE')
            <button
                onclick="toggleReplyForm('{{ $comment->comment_id }}', '{{ $comment->user->username }}')"
                type="button"
                class="text-blue-500 hover:underline"
            >
                Trả lời
            </button>
            <button
                onclick="toggleReplies('{{ $comment->comment_id }}')"
                type="button"
                class="text-gray-500 hover:underline"
            >
                ({{ $comment->replies->count() }}) <!-- Hiển thị số lượng trả lời -->
            </button>

            @if (Auth::id() === $comment->user_id)
            <button type="submit" class="text-red-600 hover:text-red-800">Xóa</button>
            @endif
        </form>

        <!-- Form trả lời ẩn -->
        <form id="reply-form-{{ $comment->comment_id }}" action="{{ route('comments_store', ['post' => $post->id]) }}" method="POST" class="hidden mt-4">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->comment_id }}">
            <textarea
                id="reply-textarea-{{ $comment->comment_id }}"
                class="w-full p-2 border rounded-lg mb-2"
                name="content"
                placeholder="Nhập trả lời của bạn"
                rows="2"
                oninput="autoResize(this)"
                required
            ></textarea>
            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg">Gửi trả lời</button>
        </form>

        <!-- Hiển thị các bình luận con -->
        @if ($comment->replies)
        <div id="replies-{{ $comment->comment_id }}" class="mt-4 {{ $depth < 2 ? 'ml-10' : '' }} hidden">
            @foreach ($comment->replies as $reply)
            @include('posts.comment_replies', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
        @endif
    </div>
</div>