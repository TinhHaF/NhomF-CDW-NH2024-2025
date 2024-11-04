<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #000000;
        }

        .container {
            width: 800px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .breadcrumb {
            font-size: 14px;
            color: #666666;
        }

        .breadcrumb a {
            color: #666666;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666666;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
        }

        .content p {
            margin: 10px 0;
        }

        .image {
            text-align: center;
            /* Căn giữa hình ảnh */
        }

        .image img {
            max-width: 100%;
            height: auto;
            display: inline-block;
            /* Đảm bảo hình ảnh không bị kéo dài */
        }

        .image-caption {
            font-size: 14px;
            color: #666666;
            margin-top: 5px;
        }
        
    </style>
</head>

<body class="bg-gray-100 p-8">
    @include('components.notifications')
    <div class="container">
        <div class="title">
            {{ $post->title }}
        </div>
        <div class="meta">
            <div class="date">
                {{ $post->created_at->format('d/m/Y H:i') }} (GMT+7)
            </div>
            <div class="author">
                Tác giả: {{ $post->author->pen_name ?? 'Chưa có tác giả' }}
            </div>
        </div>
        <div class="content">
            <div class="image">
                <img alt="{{ $post->title }}" src="{{ asset('storage/' . $post->image) }}" />
            </div>
            <p>
                {!! $post->content !!}
            </p>
        </div>
    </div>
    @include('posts.post_commemts')
</body>


</html>