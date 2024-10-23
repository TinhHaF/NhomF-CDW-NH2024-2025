@extends('admin.layout')

@section('content')

    <body>
        <div class="m-4">
            <!-- Success Notification -->
            @if (session('success'))
                <div id="toast"
                    class="fixed top-4 right-4 bg-green-600 text-white mt-4 p-4 rounded-lg shadow-lg transform transition-transform duration-500 border-l-4 border-green-800"
                    style="transform: translateX(100%); z-index: 1000;">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toast = document.getElementById('toast');
                        toast.style.transform = 'translateX(0)';
                        setTimeout(() => {
                            toast.style.transform = 'translateX(100%)';
                            setTimeout(() => {
                                toast.style.display = 'none';
                            }, 500);
                        }, 3000);
                    });
                </script>
            @endif

            <!-- Dashboard Navigation -->
            <div class="flex items-center mb-4">
                <span class="text-sm font-bold text-blue-600">Bảng điều khiển</span>
                <span class="mx-2">/</span>
                <span class="text-sm font-bold">Quản lý tin tức</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center mb-4">
                <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
                <!-- Thêm nút 'Xóa tất cả' -->
                <form action="{{ route('posts.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash"></i> Xóa tất cả
                    </button>
                </form>

                <div class="flex items-center border rounded overflow-hidden ml-2">
                    <form action="{{ route('posts.index') }}" method="GET" class="flex items-center">
                        <input name="search" class="px-4 py-2" placeholder="Tìm kiếm" type="text"
                            value="{{ request()->get('search') }}" />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>



            <!-- Posts Table -->
            <div class="overflow-x-auto border">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="w-full p-4 text-sm border-b">
                            <th class="py-2 px-4">
                                <input type="checkbox" />
                            </th>
                            <th class="py-2 px-4">STT</th>
                            <th class="py-2 px-4">Hình</th>
                            <th class="float-start py-2 px-4">Tiêu đề</th>
                            <th class="py-2 px-4">Nổi bật</th>
                            <th class="py-2 px-4">Hiển thị</th>
                            <th class="float-start py-2 px-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" name="post_ids[]" value="{{ $post->id }}"
                                        form="bulkDeleteForm" />
                                </td>
                                <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                        width="100" height="100">

                                </td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div>{{ $post->title }}</div>
                                    <div class="text-sm text-gray-500 mb-2">Ngày tạo:
                                        {{ $post->created_at->format('d/m/Y') }}</div>
                                    <div class="flex space-x-2">
                                        <a class="text-blue-500" href="{{ route('posts.show', $post->id) }}"
                                            title="Xem bài viết">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a class="text-green-500" href="{{ route('posts.edit', $post->id) }}"
                                            title="Sửa bài viết">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" title="Xóa bài viết">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('posts.updateStatus', $post->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="checkbox" name="is_featured" value="1"
                                            {{ $post->is_featured ? 'checked' : '' }} onchange="this.form.submit()"
                                            title="Nổi bật bài viết" />
                                    </form>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <form action="{{ route('posts.updateStatus', $post->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="checkbox" name="is_published" value="1"
                                            {{ $post->is_published ? 'checked' : '' }} onchange="this.form.submit()"
                                            title="Hiển thị bài viết" />
                                    </form>
                                </td>

                                <td class="py-2 px-4 border-b">
                                    <div class="flex items-center space-x-2">
                                        <!-- Sao chép bài viết -->
                                        <i class="fas fa-copy text-green-500 cursor-pointer" title="Sao chép bài viết"
                                            onclick="document.getElementById('copyPost{{ $post->id }}').submit();"></i>
                                        <form action="{{ route('posts.copy', $post->id) }}" method="POST"
                                            id="copyPost{{ $post->id }}" style="display: inline;">
                                            @csrf
                                        </form>

                                        <!-- Sửa bài viết -->
                                        <a class="text-green-500" href="{{ route('posts.edit', $post->id) }}"
                                            title="Sửa bài viết">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Xóa bài viết -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" title="Xóa bài viết"
                                                style="background: none; border: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </body>
@endsection
