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
        {{-- Hiển thị danh sách bình luận --}}
        @foreach ($comments as $comment)
        @include('posts.comment_replies', ['comment' => $comment, 'depth' => 0])
        @endforeach

        <!-- Phân trang cho bình luận -->
        <div>
            {{ $comments->links() }}
        </div>
    </div>

    <script>
        // Hàm ẩn/hiện form trả lời và tự động thêm @username
        function toggleReplyForm(commentId, username) {
            const replyForm = document.getElementById('reply-form-' + commentId);
            const replyTextarea = document.getElementById('reply-textarea-' + commentId);

            if (replyForm) {
                replyForm.classList.toggle('hidden');

                // Nếu textarea chưa có nội dung, thêm @username
                if (replyTextarea && replyTextarea.value.trim() === '') {
                    replyTextarea.value = `@${username} `;
                    replyTextarea.focus(); // Đưa con trỏ vào textarea
                }
            }
        }
        // Hàm tự động mở rộng textarea khi nhập
        function autoResize(textarea) {
            textarea.style.height = 'auto'; // Đặt chiều cao về tự động
            textarea.style.height = textarea.scrollHeight + 'px'; // Cập nhật chiều cao theo nội dung
        }
    </script>
    </body>

    </html>