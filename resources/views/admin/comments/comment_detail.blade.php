@extends('admin.layout')
@section('content')

<body>
    <div class="m-4">
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                </li>
                <li>/</li>
                <li><a href="{{ route('PostsComment') }} " class="">Bài Viết</a></li>
                <li>/</li>
                <li><a href="{{ route('PostsComment') }}">Bình Luận</a></li>
                <li>/</li>
                <li><a class="text-blue-600 hover:text-blue-700">Chi Tiết</a></li>
            </ol>
        </nav>

        <!-- Thông Tin Bình Luận -->
        <div class="space-y-4">
            <div class="flex items-center space-x-3">

            <img src="{{ $comment->user->image 
            ? asset('storage/' . $comment->user->image) 
            : asset('user_avt/avt.jpg') }}" 
     alt="Avatar" 
     class="w-12 h-12 rounded-full border-2 border-blue-500">

                
                <div>
                    <p class="text-xl font-semibold text-gray-800">{{ $comment->user->username }}</p>
                    <p class="text-sm text-gray-500">Đã bình luận vào {{ $comment->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800">Nội Dung Bình Luận</h3>
                <p class="text-lg text-gray-700 mt-2">{{ $comment->content }}</p>
            </div>

            <!-- Buttons or actions -->
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('PostsComment') }}" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition">Quay lại</a>
                <!-- Form xóa bình luận
                <form action="{{ route('comments.admin_delete', $comment->comment_id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition">
                        Xóa Bình Luận
                    </button>
                </form> -->
            </div>
        </div>
    </div>
</body>
@endsection