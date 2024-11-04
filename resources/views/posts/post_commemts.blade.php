<html>

<head>
    <title>Comments Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .comments-section {
            width: 800px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .comments-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .comment-input {
            width: 100%;
            height: 100px;
            /* Đặt chiều cao lớn hơn cho ô nhập liệu */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .comments-section .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .comments-section .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #333;
        }

        .comments-section .tab.active {
            color: #e74c3c;
            border-bottom: 2px solid #e74c3c;
        }

        .comments-section .comment {
            display: flex;
            margin-bottom: 20px;
        }

        .comments-section .comment .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 10px;
            margin-top: 5px;
        }

        .comments-section .comment .content {
            flex: 1;
        }

        .comments-section .comment .content .name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comments-section .comment .content .text {
            margin-bottom: 5px;
        }

        .comments-section .comment .content .actions {
            display: flex;
            align-items: center;
            color: #999;
        }

        .comments-section .comment .content .actions .action {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .comments-section .comment .content .actions .action i {
            margin-right: 5px;
        }

        .comments-section .comment .content .actions .action .count {
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="comments-section">
        <h2>Bình Luận ({{ $post->comments->count() }})</h2>

        <!-- Form bình luận -->
        <form action="{{ route('post.comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <textarea class="comment-input" name="content" placeholder="Chia sẻ ý kiến của bạn" required></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-2">
                Gửi bình luận
            </button>
        </form>

        <div class="tabs">
            <div class="tab active">Mới nhất</div>
            <div class="tab">#</div>
        </div>

        @foreach ($post->comments->reverse() as $comment)
        <div class="comment">
            <div class="avatar" style="background-image: url('https://placehold.co/40x40');"></div>
            <div class="content">
                <div class="name">{{ $comment->user->username }}</div>
                <div class="text">{{ $comment->content }}</div>
                <div class="actions">
                    <div class="action">
                        <i class="fas fa-thumbs-up"></i> Thích <span class="count">14</span>
                    </div>
                    <div class="action">
                        <i class="fas fa-reply"></i> Trả lời
                    </div>
                    <div class="action">
                        <span>{{ $comment->created_at->format('H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</body>

</html>