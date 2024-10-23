@extends('admin.layout')

@section('content')

    <body class="bg-gray-100">
        <div class="flex flex-col md:flex-row m-4">
            <!-- Main Content -->
            <div class="w-full md:w-5/5">

                <div class="mb-4">
                    <span class="text-blue-600 font-semibold">Bảng điều khiển</span> / Thêm mới tin tức
                </div>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="flex flex-col md:flex-row mb-4">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0"
                            type="submit">Lưu</button>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0">Làm Lại</button>
                        <button class="bg-red-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0"><a
                                href="{{ route('posts.index') }}">Thoát</a></button>
                    </div>
                    @csrf
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-2/3">
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="title">Tiêu đề</label>
                                <input type="text" name="title" id="title" required
                                    class="h-8 border-2 w-full px-2">
                            </div>
                            <div class="mb-4">
                                <label class="block font-semibold mb-2" for="content">Nội Dung</label>
                                <textarea name="content" id="editor" required class="w-full border-2" rows="10"></textarea> <!-- CKEditor -->
                            </div>
                            <div class="flex justify-start mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Lưu</button>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 pl-0 md:pl-4 mt-4 md:mt-0">
                            <!-- Chọn Danh Mục -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Danh Mục</label>
                                <select name="category_id" class="bg-white border rounded p-2 w-full" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Chọn Tác Giả -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Tác Giả</label>
                                <select name="author_id" class="bg-white border rounded p-2 w-full" required>
                                    <option value="">Chọn tác giả</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->pen_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Hình ảnh Tin tức</label>
                                <div class="bg-gray-200 border rounded p-4 text-center">
                                    <img alt="No image available" class="mx-auto mb-4" height="205" width="360"
                                        id="previewImage"
                                        src="{{ isset($post) && $post->image ? asset('storage/' . $post->image) : asset('images/no-image-available.jpg') }}"
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
    </body>
@endsection
