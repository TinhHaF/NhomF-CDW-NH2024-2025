@extends('admin.layout')
@section('content')

    <body class="bg-gray-100">
        <div class="flex flex-col md:flex-row m-4">
            <div class="w-full md:w-5/5">

                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <div class="flex items-center">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-700">Bảng điều khiển</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span class="text-sm font-medium">/</span>
                                <span class="ml-2 text-sm font-medium text-gray-700">Thêm mới tin tức</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white p-6 rounded-lg shadow-md" id="newsForm">
                    @csrf
                    <div class="flex flex-col md:flex-row mb-4">
                        <button
                            class="flex items-center bg-green-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-green-600"
                            type="submit">
                            <i class="fas fa-save mr-2"></i>Lưu
                        </button>
                        <button type="reset"
                            class="flex items-center bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-gray-400"
                            onclick="confirmReset()">
                            <i class="fas fa-redo mr-2"></i>Làm Lại
                        </button>
                        <a href="{{ route('posts.index') }}"
                            class="flex items-center bg-red-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-red-600">
                            <i class="fas fa-times mr-2"></i>Thoát
                        </a>
                    </div>

                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-2/3 pr-0 md:pr-4">
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="title">Tiêu đề</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    oninput="generateSlug()"
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập tiêu đề">
                                @error('title')
                                    <div class="text-danger focus-ring-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Slug tự động tạo">
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="content">Nội Dung</label>
                                <textarea name="content" id="editor" required class="w-full border border-gray-300 rounded px-3 py-2" rows="10"
                                    placeholder="Nhập nội dung">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 pl-0 md:pl-4 mt-4 md:mt-0">
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Danh Mục</label>
                                <select name="category_id" class="bg-white border border-gray-300 rounded p-2 w-full"
                                    required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Tác Giả</label>
                                <select name="author_id" class="bg-white border border-gray-300 rounded p-2 w-full"
                                    required>
                                    <option value="">Chọn tác giả</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                            {{ $author->pen_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Hình ảnh Tin tức</label>
                                <div class="border border-gray-300 rounded p-4 text-center">
                                    <img alt="No image available" class="mx-auto mb-4" height="205" width="250"
                                        id="previewImage"
                                        src="{{ isset($post) && $post->image ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}"
                                        style="display: block;" />

                                    <div class="bg-[#F5F5F5] border-dashed border-2 border-gray-400 p-4">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                        <p>Kéo và thả hình vào đây</p>
                                        <p>hoặc</p>
                                        <input type="file" name="image" id="image" class="hidden" accept="image/*"
                                            onchange="previewFile()">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <button type="button" onclick="document.getElementById('image').click()"
                                            class="bg-green-500 text-white px-4 py-2 rounded">Chọn hình</button>
                                    </div>
                                    <p class="text-xs mt-2">Width: 360 px - Height: 205 px
                                        (.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF)</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="seo_title">SEO Tiêu đề</label>
                                <input type="text" name="seo_title" id="seo_title" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập SEO Tiêu đề" value="{{ old('seo_title') }}">
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="seo_description">SEO Mô tả</label>
                                <textarea name="seo_description" id="seo_description" required
                                    class="w-full border border-gray-300 rounded px-3 py-2" rows="3" placeholder="Nhập SEO Mô tả">{{ old('seo_description') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="seo_keywords">SEO Từ khóa</label>
                                <input type="text" name="seo_keywords" id="seo_keywords" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập SEO Từ khóa" value="{{ old('seo_keywords') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function confirmReset() {
                if (confirm("Bạn có chắc chắn muốn làm lại không?")) {
                    document.getElementById('newsForm').reset(); // Reset the form
                    // Optional: Reset any preview images or other specific fields if needed
                    document.getElementById('previewImage').src =
                    '{{ asset('images/no-image-available.jpg') }}'; // Reset image preview
                }
            }
        </script>
    </body>
@endsection
