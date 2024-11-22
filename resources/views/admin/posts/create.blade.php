@extends('admin.layout')
@section('content')

    <body class="bg-gray-100">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif --}}
        <div class="flex flex-col md:flex-row m-4">
            <div class="w-full md:w-5/5">

                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <div class="flex items-center">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-700">Bảng điều khiển</a>
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

                <div class="flex flex-col md:flex-row mb-4">
                    <button
                        class="flex items-center bg-green-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-green-600"
                        type="submit" form="postForm">
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



                <form id="postForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                    id="newsForm">
                    @csrf

                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-2/3 pr-0">
                            <div
                                class="mb-4 bg-white shadow-md rounded-lg overflow-hidden text-sm p-2 border-t-4 border-blue-500">
                                <div class="p-4 flex">
                                    <h3 class="block font-semibold mr-2">Đường dẫn</h3>
                                    <span class="text-red-500">(Vui lòng không nhập trùng tiêu đề)</span>
                                </div>
                                <div class="p-4">
                                    <input type="hidden" class="slug-id" value="626">
                                    <input type="hidden" class="slug-copy" value="0">

                                    <div class="rounded-lg border border-gray-300 shadow-md">
                                        <div class="p-3 border-b">
                                            <ul class="flex space-x-4">
                                                <li>
                                                    <a class="text-blue-600 font-semibold active" id="tabs-lang"
                                                        data-toggle="pill" href="" role="tab"
                                                        aria-controls="tabs-sluglang-vi" aria-selected="true">Tiếng Việt</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="p-4">
                                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                                <div class="tab-pane fade show active" id="tabs-sluglang-vi" role="tabpanel"
                                                    aria-labelledby="tabs-lang">
                                                    <div class="mb-0">
                                                        <label class="block">Đường dẫn mẫu (vi):
                                                            <span class="pl-2 font-normal text-gray-700"
                                                                id="slugurlpreviewvi">http://127.0.0.1:8000/
                                                                <strong class="text-blue-600"></strong>
                                                            </span>
                                                        </label>
                                                        <input type="text" name="slug" id="slug" required
                                                            class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                                            placeholder="Đường dẫn mẫu">
                                                        <input type="hidden" id="slug-defaultvi" value="$value">

                                                        <p class="alert-slugvi text-red-500 hidden mt-2 mb-0"
                                                            id="alert-slug-dangervi">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            <span>Đường dẫn đã tồn tại. Đường dẫn truy cập mục này có thể bị
                                                                trùng
                                                                lặp.</span>
                                                        </p>
                                                        <p class="alert-slugvi text-green-500 hidden mt-2 mb-0"
                                                            id="alert-slug-successvi">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            <span>Đường dẫn hợp lệ.</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
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
                                    <label class="block font-semibold mb-2" for="content">Nội Dung</label>
                                    <textarea name="content" id="editor" required class="w-full border border-gray-300 rounded px-3 py-2" rows="10"
                                        placeholder="Nhập nội dung">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 pl-0 md:pl-4 mt-4 md:mt-0">
                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
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
                                        <input type="file" name="image" id="image" class="hidden"
                                            accept="image/*" onchange="previewFile()">
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
                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2">Danh Mục</label>
                                <select name="category_id" id="category_id" required
                                    class="w-full h-10 px-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2">Tác Giả</label>
                                <select name="author_id" class="bg-white border border-gray-300 rounded px-3 h-10 w-full"
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

                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2" for="seo_title">SEO Tiêu đề</label>
                                <input type="text" name="seo_title" id="seo_title" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập SEO Tiêu đề" value="{{ old('seo_title') }}">

                                <label class="block font-semibold mb-2" for="seo_description">SEO Mô tả</label>
                                <textarea name="seo_description" id="seo_description" required
                                    class="w-full border border-gray-300 rounded px-3 py-2" rows="3" placeholder="Nhập SEO Mô tả">{{ old('seo_description') }}</textarea>

                                <label class="block font-semibold mb-2" for="seo_keywords">SEO Từ khóa</label>
                                <input type="text" name="seo_keywords" id="seo_keywords" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập SEO Từ khóa" value="{{ old('seo_keywords') }}">
                            </div>
                            {{-- Tag --}}
                            {{-- <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2">Tags</label>
                                <select name="tags[]" id="tags" multiple
                                    class="w-full h-32 px-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ isset($post) && $post->tags->contains($tag->id) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Giữ Ctrl (Windows) hoặc Command (Mac) để chọn nhiều
                                    tags</p>
                            </div> --}}
                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2">Tags mới (nếu có)</label>
                                <input type="text" name="new_tags" placeholder="Nhập tag mới, cách nhau bằng dấu phẩy"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <p class="text-sm text-gray-500 font-mono mt-1">Mỗi 1 tag cách nhau bằng dấu phấy (,)</p>
                            </div>

                        </div>
                    </div>
                </form>
                <div class="flex flex-col md:flex-row mt-4">
                    <button
                        class="flex items-center bg-green-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-green-600"
                        type="submit" form="postForm">
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
            </div>
        </div>


    </body>
@endsection

@push('scripts')
    <script>
        function confirmReset() {
            if (confirm("Bạn có chắc chắn muốn làm lại không?")) {
                document.getElementById("postForm").reset();
                document.getElementById("previewImage").src = '{{ asset('images/no-image-available.jpg') }}';
            }
        }

        function previewFile() {
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImage').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }


        $(document).ready(function() {
            $('#tags').select2({
                placeholder: 'Chọn tags',
                allowClear: true
            });
        });

        // Gọi hàm setupSlugAutoUpdate
        document.addEventListener("DOMContentLoaded", function() {
            setupSlugAutoUpdate("#slug", "#slugurlpreviewvi");
        });
    </script>
@endpush
{{-- @php
    \Log::info('Categories in view:', ['categories' => $categories->toArray()]);
@endphp --}}
