@extends('admin.layout')

@section('content')

    <body class="bg-gray-100">
        <div class="flex flex-col md:flex-row m-4">
            <!-- Main Content -->
            <div class="w-full md:w-5/5">

                <div class="mb-4">
                    <span class="text-blue-600 font-semibold">Bảng điều khiển</span> / Chỉnh sửa tin tức
                </div>
                <form action="{{ route('posts.index', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col md:flex-row mb-4">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0" type="submit">Cập nhật</button>
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0"
                            onclick="window.history.back();">Thoát</button>
                    </div>
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-2/3">
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="title">Tiêu đề</label>
                                <input type="text" name="title" id="title" value="{{ $post->title }}" required
                                    class="h-8 border-2 w-full px-2">
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="content">Nội Dung</label>
                                <textarea name="content" id="editor" required class="w-full border-2" rows="10">{{ $post->content }}</textarea> <!-- CKEditor -->
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 pl-0 md:pl-4 mt-4 md:mt-0">
                            <!-- Chọn Danh Mục -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Danh Mục</label>
                                <select name="category_id" class="bg-white border rounded p-2 w-full" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Chọn Tác Giả -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Tác Giả</label>
                                <select name="author_id" class="bg-white border rounded p-2 w-full" required>
                                    <option value="">Chọn tác giả</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            {{ $post->author_id == $author->id ? 'selected' : '' }}>{{ $author->pen_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hình ảnh Tin tức -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Hình ảnh Tin tức</label>
                                <div class="bg-gray-200 border rounded p-4 text-center">
                                    <img alt="Preview image" class="mx-auto mb-4" height="205" width="360"
                                        id="previewImage" src="{{ asset('storage/' . $post->image) }}"
                                        style="display: block;" />
                                    <div class="bg-gray-100 border-dashed border-2 border-gray-400 p-4">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                        <p>Kéo và thả hình vào đây</p>
                                        <p>hoặc</p>
                                        <input type="file" name="image" id="image" class="hidden" accept="image/*"
                                            onchange="previewFile()">
                                        <button type="button" onclick="document.getElementById('image').click()"
                                            class="bg-green-500 text-white px-4 py-2 rounded">Chọn hình</button>
                                    </div>
                                    <p class="text-xs mt-2">Width: 360 px - Height: 205 px (.jpg, .gif, .png, .jpeg)</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function previewFile() {
                const preview = document.getElementById('previewImage');
                const file = document.getElementById('image').files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result; // Cập nhật src của img với kết quả từ FileReader
                    preview.style.display = 'block'; // Hiển thị hình ảnh
                }

                if (file) {
                    reader.readAsDataURL(file); // Đọc dữ liệu hình ảnh
                } else {
                    preview.src = ""; // Nếu không có hình ảnh, đặt src rỗng
                    preview.style.display = 'none'; // Ẩn hình ảnh
                }
            }
        </script>
    </body>
@endsection
