<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tác giả</title>
    <!-- Đường dẫn đến CSS của Tailwind -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">

            <!-- Nút quay lại trang chủ ở góc trái -->
            <div class="absolute top-4 left-4">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm bg-gray-600 text-white rounded-full hover:bg-gray-700 transition duration-300">
                    Quay lại trang chủ
                </a>
            </div>

            <!-- Hiển thị thông báo nếu có -->
            @if(session('status'))
                <div id="statusMessage" class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    <p>{{ session('status') }}</p>
                </div>

                <script>
                    // Ẩn thông báo sau 3 giây
                    setTimeout(function () {
                        document.getElementById('statusMessage').style.display = 'none';
                    }, 3000); // 3000 ms = 3 giây
                </script>
            @endif

            <h1 class="text-4xl font-bold text-center text-gray-900 mb-6">
                <div class="flex justify-center items-center gap-3 mb-4">
                    <!-- Ảnh tác giả -->
                    @if($author->image)
                        <img src="{{ asset('storage/authors/' . $author->image) }}" alt="{{ $author->pen_name }}"
                            class="rounded-full w-24 h-24 object-cover border-4 border-white shadow-lg">
                    @else
                        <img src="{{ asset('default-avatar.jpg') }}" alt="Avatar mặc định"
                            class="rounded-full w-24 h-24 object-cover border-4 border-white shadow-lg">
                    @endif
                    <span>{{ $author->pen_name ?? 'Tác giả không có biệt danh' }}</span>
                </div>
            </h1>

            <div class="mb-6">
                <p><strong class="text-lg font-semibold">Tiểu sử:</strong></p>
                <p class="text-gray-700 leading-relaxed">{{ $author->biography ?? 'Chưa có tiểu sử' }}</p>
            </div>

            <div class="mb-6">
                <p><strong class="text-lg font-semibold">Ngày ra mắt:</strong></p>
                <p class="text-gray-700">
                    {{ $author->published_date ? \Carbon\Carbon::parse($author->published_date)->format('d-m-Y') : 'Chưa có ngày ra mắt' }}
                </p>
            </div>

            <!-- Nút đăng ký theo dõi (nếu đã đăng nhập) -->
            @auth
                <div class="text-center mb-6">
                    @if(auth()->user()->isFollowing($author))
                        <form action="{{ route('authors.unfollow', Hashids::encode($author->id)) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition duration-300">
                                Hủy theo dõi
                            </button>
                        </form>
                    @else
                        <form action="{{ route('authors.follow', Hashids::encode($author->id)) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
                                Đăng ký theo dõi
                            </button>
                        </form>
                    @endif
                </div>
            @endauth

            <!-- Bài viết của tác giả -->
            @if($posts->count())
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Bài viết của tác giả:</h3>
                    <ul class="space-y-3">
                        @foreach($posts as $post)
                            <li>
                                <a href="{{ route('posts.show', $post->id) }}"
                                    class="text-blue-600 hover:text-blue-800 transition duration-300">
                                    {{ $post->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Hiển thị phân trang -->
                    <div class="mt-6">
                        {{ $posts->links('pagination::tailwind') }}
                    </div>
                </div>
            @else
                <p class="text-gray-600">Tác giả chưa có bài viết nào.</p>
            @endif
        </div>
    </div>
</body>
</html>
