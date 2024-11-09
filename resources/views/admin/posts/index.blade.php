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
                            <a href="{{ route('admin.dashboard') }}" class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-700">Bảng điều
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
                        <input name="search" class="px-4 py-2" placeholder="Tìm kiếm" type="text"
                            value="{{ request()->get('search') }}" />
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
                                    <input type="checkbox" name="post_ids[]" value="{{ $post->id }}"
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
                                        onclick="openModal('{{ $post->id }}', '{{ $post->title }}', '{{ $post->content }}')">
                                        <div>{{ $post->title }}</div>
                                    </a>
                                    <div class="text-sm text-gray-500 mb-2">Ngày tạo:
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <a class="text-blue-500"
                                            href="{{ route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug]) }}"
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
                                <form action="{{ route('posts.updateStatus', $post->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="title" value="{{ $post->title }}" />
                                    <!-- Thêm trường này -->
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
            <!-- Modal -->
            <div id="postModal"
                class="fixed inset-0 hidden bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full md:w-1/3 max-w-lg">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 id="modalPostTitle" class="text-xl font-bold text-gray-800 truncate"></h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800 text-lg">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4">
                        <!-- Post Image -->
                        <div class="mb-4">
                            <img id="modalPostImage" class="w-full h-48 object-cover rounded-lg" alt="Post Image" />
                        </div>

                        <!-- Post Content -->
                        <p id="modalPostContent" class="text-gray-700 text-sm leading-relaxed"></p>
                    </div>
                </div>
            </div>

        </div>
        <script>
            function openModal(postId, title, content, imageUrl) {
                // Set the modal title and content
                document.getElementById('modalPostTitle').innerText = title;
                document.getElementById('modalPostContent').innerText = content;

                // Set the modal image
                const modalImage = document.getElementById('modalPostImage');
                modalImage.src = imageUrl ? imageUrl : '{{ asset('images/no-image-available.jpg') }}'; // Default image if no image is provided

                // Show the modal
                document.getElementById('postModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('postModal').classList.add('hidden');
            }
        </script>
    </body>
@endsection
