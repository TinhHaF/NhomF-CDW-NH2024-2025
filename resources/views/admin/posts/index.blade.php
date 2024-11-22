@extends('admin.layout')
@section('content')

    <body>
        {{-- Thông báo khi không tìm thấy bài viết --}}
        @if ($message)
            <!-- Modal Background -->
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg max-w-lg mx-auto text-center p-8">
                    <div class="text-2xl font-semibold text-gray-800 mb-6">Thông Báo</div>
                    <p class="text-sm text-black-700 mb-6">{{ $message }}</p>
                    <button onclick="this.closest('.fixed').remove()"
                        class="mt-4 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-full transition duration-200 ease-in-out transform hover:scale-105">
                        Đóng
                    </button>
                </div>
            </div>
        @endif

        <div class="m-4">
            <!-- Dashboard Navigation -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-700">Bảng điều
                                khiển</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="text-sm font-medium">/</span>
                            <span class="ml-2 text-sm font-medium text-gray-700">Quản lý tin tức</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center mb-4">
                <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
                <!-- Thêm nút 'Xóa tất cả' -->
                <form action="{{ route('posts.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                    @csrf
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded"
                        onclick="bulkDeleteSystem.confirmDelete()">
                        <i class="fas fa-trash"></i> Xóa tất cả (<span id="selectedCount">0</span>)
                    </button>
                </form>


                <div class="flex items-center border rounded overflow-hidden ml-2">
                    <form action="{{ route('posts.index') }}" method="GET" class="flex items-center">
                        <input name="search" class="px-4 py-2" placeholder="Tìm kiếm theo tiêu đề hoặc nội dung"
                            type="text" value="{{ request()->get('search') }}" />
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="overflow-x-auto rounded border-t-4 border-blue-500">
                <div class="title text-sm p-2 bg-white border-b font-monospace">
                    Danh sách Bài Viết
                </div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr class="w-full p-4 text-sm border-b">
                            <th class="px-6 py-4 text-center">
                                <input type="checkbox" id="selectAll"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">STT
                            </th>
                            <th class="py-4 px-10 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Hình
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Tiêu đề
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">Nổi
                                bật</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600">Hiển
                                thị</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Thao
                                tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" name="post_ids[]" value="{{ $encodeId($post->id) }}"
                                        form="bulkDeleteForm" class="selectItem" />
                                </td>
                                <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{-- <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}"
                            alt="{{ $post->title }}" width="100" height="100"> --}}

                                    <img alt="Preview image" height="100" width="100"
                                        src="{{ isset($post->image) && file_exists(public_path('storage/' . $post->image)) ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}">

                                </td>

                                <td class="py-2 px-4 border-b text-left">
                                    <a href="javascript:void(0)"
                                        onclick="openModal('{{ $encodeId($post->id) }}', 
                                        '{{ $post->title }}', 
                                        `{{ $post->content }}`, 
                                        `{{ isset($post->image) && file_exists(public_path('storage/' . $post->image)) ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}`)">
                                        <div class="text-blue-600 hover:text-blue-800 font-semibold">
                                            {{ $post->title }}
                                        </div>
                                    </a>

                                    <div class="text-sm text-gray-500 mb-2">Ngày tạo:
                                        {{ $post->created_at->format('d/m/Y') }}</div>
                                    <div class="flex space-x-2">
                                        <a class="text-blue-500"
                                            href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                            title="Xem bài viết">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a class="text-green-500" href="{{ route('posts.edit', $encodeId($post->id)) }}"
                                            title="Sửa bài viết">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('posts.destroy', $encodeId($post->id)) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" title="Xóa bài viết">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                                <form action="{{ route('posts.updateStatus', $encodeId($post->id)) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="title" value="{{ $post->title }}" />
                                    <td class="py-2 px-4 border-b">
                                        <input type="checkbox" name="is_featured" value="1"
                                            {{ $post->is_featured ? 'checked' : '' }} onchange="this.form.submit()"
                                            title="Nổi bật bài viết" />
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <input type="checkbox" name="is_published" value="1"
                                            {{ $post->is_published ? 'checked' : '' }} onchange="this.form.submit()"
                                            title="Hiển thị bài viết" />
                                    </td>
                                </form>

                                <td class="py-2 px-4 border-b">
                                    <div class="flex items-center space-x-2">
                                        <!-- Sao chép bài viết -->
                                        <i class="fas fa-copy text-green-500 cursor-pointer" title="Sao chép bài viết"
                                            onclick="document.getElementById('copyPost{{ $encodeId($post->id) }}').submit();"></i>
                                        <form action="{{ route('posts.copy', $encodeId($post->id)) }}" method="POST"
                                            id="copyPost{{ $encodeId($post->id) }}" style="display: inline;">
                                            @csrf
                                        </form>

                                        <!-- Sửa bài viết -->
                                        <a class="text-green-500" href="{{ route('posts.edit', $encodeId($post->id)) }}"
                                            title="Sửa bài viết">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Xóa bài viết -->
                                        <form action="{{ route('posts.destroy', $encodeId($post->id)) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500" title="Xóa bài viết">
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
            <!-- Modal Overlay -->
            <div id="postModal"
                class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden z-50 flex items-center justify-center">
                <!-- Modal Container -->
                <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b p-4">
                        <h2 id="modalPostTitle" class="text-xl font-semibold text-gray-800"></h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800 text-lg">&times;</button>
                    </div>
                    <!-- Modal Body -->
                    <div class="p-4">
                        <img id="modalPostImage" class="w-full rounded-md mb-4" src="" alt="Post Image">
                        <div id="modalPostContent" class="text-gray-700"></div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="flex justify-end p-4 border-t">
                        <button onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const bulkDeleteSystem = {
                confirmDelete: function() {
                    const selectedItems = document.querySelectorAll('.selectItem:checked');
                    if (selectedItems.length === 0) {
                        alert('Vui lòng chọn ít nhất một bài viết để xóa');
                        return;
                    }

                    if (confirm('Bạn có chắc chắn muốn xóa các bài viết đã chọn?')) {
                        document.getElementById('bulkDeleteForm').submit();
                    }
                }
            };

            // Update selected count
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const selectItems = document.querySelectorAll('.selectItem');
                const selectedCount = document.getElementById('selectedCount');

                function updateSelectedCount() {
                    const count = document.querySelectorAll('.selectItem:checked').length;
                    selectedCount.textContent = count;
                }

                selectAll.addEventListener('change', function() {
                    selectItems.forEach(item => item.checked = this.checked);
                    updateSelectedCount();
                });

                selectItems.forEach(item => {
                    item.addEventListener('change', function() {
                        updateSelectedCount();
                        selectAll.checked = [...selectItems].every(item => item.checked);
                    });
                });
            });

            
        </script>
    </body>
@endsection
