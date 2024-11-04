<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="min-h-screen flex flex-col">
        @include('home.nav')

        <!-- Tin Đề Xuất -->
        <div class="flex-grow">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-6">Tin Đề Xuất</h2>
                @if (isset($posts) && $posts->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md">
                        <a href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}" class="block">
                            <h5 class="text-lg font-semibold p-4 hover:underline">
                                {{ $post->title }}
                            </h5>
                            <div class="flex">
                                @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}"
                                    class="w-1/2 h-48 object-cover rounded-l-lg ml-1 mb-1"
                                    alt="{{ $post->title }}">
                                @endif
                                <div class="p-4 w-1/2">
                                    <p class="text-gray-600">{!! Str::limit($post->content, 100) !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500">Không có tin đề xuất nào để hiển thị.</p>
                @endif
            </div>
        </div>


        <!-- Tin Nổi Bật -->
        <div class="flex-grow">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-6">Tin Nổi Bật</h2>
                @if (isset($featuredPosts) && $featuredPosts->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($featuredPosts as $postf)
                    <div class="bg-white rounded-lg shadow-md">
                        <a href="{{ route('posts.post_detail', ['id' => $postf->id, 'slug' => $postf->slug]) }}" class="block">
                            <h5 class="text-lg font-semibold p-4 hover:underline">
                                {{ $postf->title }}
                            </h5>
                            <div class="flex">
                                @if ($postf->image)
                                <img src="{{ asset('storage/' . $postf->image) }}"
                                    class="w-1/2 h-48 object-cover rounded-l-lg ml-1 mb-1"
                                    alt="{{ $postf->title }}">
                                @endif
                                <div class="p-4 w-1/2">
                                    <p class="text-gray-600">{!! Str::limit($postf->content, 100) !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $featuredPosts->links() }}
                </div>
                @else
                <p class="text-gray-500">Không có tin nổi bật nào để hiển thị.</p>
                @endif
            </div>
        </div>

        @include('home.footer')
    </div>
</body>

</html>