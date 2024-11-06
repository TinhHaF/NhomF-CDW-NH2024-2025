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
                <li><a class="text-blue-600 hover:text-blue-700">Bình Luận</a></li>
            </ol>
        </nav>
        <!-- Action Buttons -->
        <div class="flex items-center mb-6">
            <form action="" method="GET" class="flex items-center ml-auto">
                <input name="search" type="text" placeholder="Tìm kiếm" value="{{ request()->get('search') }}"
                    class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Comments Table -->
        <div class="overflow-x-auto border rounded-md shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 text-gray-600">
                    <tr class="text-sm uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4 text-center">STT</th>
                        <th class="px-6 py-4 text-left">Tên Người Dùng</th>
                        <th class="px-6 py-4 text-left">Nội Dung</th>
                        <th class="px-6 py-4 text-center">Thời Gian Bình Luận</th>
                        <th class="px-6 py-4 text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if($comments->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4">Không có bình luận nào.</td>
                    </tr>
                    @else
                    @foreach($comments as $index => $comment)
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ optional($comment->user)->username ?? 'Không có tên' }}</td>
                        <td class="px-6 py-4">{{ Str::limit($comment->content, 50) }}</td>
                        <td class="px-6 py-4 text-center">{{ $comment->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-4">
                                <!-- View Action -->
                                <a href="{{route('comments_detail', ['id' => $comment->comment_id])}}" title="Xem bình luận"
                                    class="text-blue-500 hover:text-blue-600">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Delete Action -->
                                <form action="{{ route('comments.admin_delete', $comment->comment_id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Xóa bình luận" class="text-red-500 hover:text-red-600"
                                        style="background: none; border: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="p-4 bg-white border-t">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</body>
@endsection