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
                                <span class="ml-2 text-sm font-medium text-gray-700">Chỉnh sửa tin tức</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row mb-4">
                    <button type="submit" form="postForm"
                        class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-blue-600">
                        <i class="fas fa-save mr-2"></i>Cập Nhật
                    </button>
                    <button type="reset" onclick="history.back()"
                        class="flex items-center bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-gray-400">
                        <i class="fas fa-redo mr-2"></i>Làm Lại
                    </button>
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center bg-red-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-red-600">
                        <i class="fas fa-times mr-2"></i>Thoát
                    </a>
                </div>

                <form id="postForm" action="{{ route('posts.update', $post->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-2/3 pr-0">
                            <div
                                class="mb-4 bg-white shadow-md rounded-lg overflow-hidden text-sm p-2 border-t-4 border-blue-500">
                                <div class="p-4 flex">
                                    <h3 class="block font-semibold mr-2">Đường dẫn</h3>
                                    <span class="text-red-500">(Vui lòng không nhập trùng tiêu đề)</span>
                                </div>
                                <div class="p-4">
                                    <div class="mb-2 flex items-center">
                                        <label for="slugchange" class="text-blue-500 mr-2">Thay đổi đường dẫn theo tiêu đề
                                            mới:</label>
                                        <input type="checkbox" class="form-checkbox" name="slugchange" id="slugchange">
                                    </div>

                                    <div class="rounded-lg border border-gray-300 shadow-md">
                                        <div class="p-4 border-b">
                                            <ul class="flex space-x-4">
                                                <li>
                                                    <a class="text-blue-600 font-semibold active" id="tabs-lang"
                                                        data-toggle="pill" href="#tabs-sluglang-vi" role="tab"
                                                        aria-controls="tabs-sluglang-vi" aria-selected="true">Tiếng Việt</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="p-4">
                                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                                <div class="tab-pane fade show active" id="tabs-sluglang-vi"
                                                    aria-labelledby="tabs-lang">
                                                    <div class="mb-0">
                                                        <label class="block">Đường dẫn mẫu (vi):<span
                                                                class="pl-2 font-normal text-gray-700"
                                                                id="slugurlpreviewvi">http://127.0.0.1:8000/<strong
                                                                    class="text-blue-600"
                                                                    id="slug-preview">{{ $post->slug }}</strong></span></label>
                                                        <div id="slugDuplicateError" class="text-red-600 hidden">Slug đã tồn
                                                            tại, vui lòng chọn slug khác.</div>
                                                        <div class="mb-4">
                                                            <input type="text" name="slug" id="slug"
                                                                value="{{ $post->slug }}" required
                                                                class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                                                placeholder="Slug tự động tạo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2" for="title">Tiêu đề</label>
                                    <input type="text" name="title" id="title" value="{{ $post->title }}" required
                                        class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                        placeholder="Nhập tiêu đề">
                                    @error('title')
                                        <div class="text-danger focus-ring-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block font-semibold mb-2" for="content">Nội Dung</label>
                                    <textarea name="content" id="editor" required class="w-full border border-gray-300 rounded px-3 py-2" rows="10"
                                        placeholder="Nhập nội dung">{{ $post->content }}</textarea>
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
                                    <img alt="Preview image" class="mx-auto mb-4" height="205" width="250"
                                        id="previewImage" src="{{ asset('storage/' . $post->image) }}"
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
                                        (.jpg|.gif|.png|.jpeg|.JPG|.PNG|.GIF)</p>
                                </div>
                            </div>

                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2">Danh Mục</label>
                                <select name="category_id"
                                    class="bg-white border border-gray-300 rounded px-3 h-10 w-full" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
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
                                            {{ $post->author_id == $author->id ? 'selected' : '' }}>
                                            {{ $author->pen_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500">
                                <label class="block font-semibold mb-2" for="seo_title">SEO Tiêu đề</label>
                                <input type="text" name="seo_title" id="seo_title" value="{{ $post->seo_title }}"
                                    required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500 mb-4"
                                    placeholder="Nhập SEO Tiêu đề">

                                <label class="block font-semibold mb-2" for="seo_description">SEO Mô tả</label>
                                <textarea name="seo_description" id="seo_description" required
                                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4" rows="3" placeholder="Nhập SEO Mô tả">{{ $post->seo_description }}</textarea>

                                <label class="block font-semibold mb-2" for="seo_keywords">SEO Từ khóa</label>
                                <input type="text" name="seo_keywords" id="seo_keywords"
                                    value="{{ $post->seo_keywords }}" required
                                    class="h-10 border border-gray-300 rounded w-full px-3 focus:outline-none focus:border-blue-500 placeholder-gray-500"
                                    placeholder="Nhập SEO Từ khóa">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="flex flex-col md:flex-row mb-4">
                    <button type="submit" form="postForm"
                        class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-blue-600">
                        <i class="fas fa-save mr-2"></i>Cập Nhật
                    </button>
                    <button type="reset" onclick="history.back()"
                        class="flex items-center bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-gray-400">
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
        // Xử lý sự kiện khi người dùng nhập tiêu đề
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slugField = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview'); // Lấy phần tử hiển thị slug

            if (document.getElementById('slugchange').checked) {
                // Tạo slug từ tiêu đề
                let slug = title
                    .normalize("NFKD") // Chuyển đổi chuẩn
                    .replace(/[\u0300-\u036f]/g, "") // Xóa dấu
                    .replace(/[đĐ]/g, "d") // Thay thế chữ có dấu
                    .trim() // Cắt khoảng trắng đầu và cuối
                    .toLowerCase() // Chuyển thành chữ thường
                    .replace(/[^a-z0-9\s-]/g, "") // Xóa ký tự đặc biệt
                    .replace(/[\s-]+/g, "-"); // Thay khoảng trắng bằng dấu '-', không cho 2 dấu '-' liên tiếp

                // Cập nhật giá trị slug và preview
                slugField.value = slug;
                slugPreview.textContent = slug; // Cập nhật hiển thị slug
            }
        });

        // Xử lý checkbox để tạo slug tự động
        document.getElementById('slugchange').addEventListener('change', function() {
            const slugField = document.getElementById('slug');
            const title = document.getElementById('title').value; // Lấy giá trị tiêu đề
            const slugPreview = document.getElementById('slug-preview'); // Lấy phần tử hiển thị slug

            if (this.checked) {
                // Tạo slug từ tiêu đề
                let slug = title
                    .normalize("NFKD") // Chuyển đổi chuẩn
                    .replace(/[\u0300-\u036f]/g, "") // Xóa dấu
                    .replace(/[đĐ]/g, "d") // Thay thế chữ có dấu
                    .trim() // Cắt khoảng trắng đầu và cuối
                    .toLowerCase() // Chuyển thành chữ thường
                    .replace(/[^a-z0-9\s-]/g, "") // Xóa ký tự đặc biệt
                    .replace(/[\s-]+/g, "-"); // Thay khoảng trắng bằng dấu '-', không cho 2 dấu '-' liên tiếp

                slugField.value = slug; // Cập nhật slug
                slugPreview.textContent = slug; // Cập nhật hiển thị slug
            } else {
                slugField.value = '{{ $post->slug }}'; // Khôi phục lại slug gốc
                slugPreview.textContent = slugField.value; // Khôi phục hiển thị slug
            }
        });

        // Kiểm tra slug trùng lặp
        document.getElementById('slug').addEventListener('input', function() {
            const slug = this.value;
            const slugDuplicateError = document.getElementById('slugDuplicateError');

            // Thực hiện AJAX kiểm tra slug trùng lặp
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `/check-slug?slug=${slug}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === 'duplicate') {
                        slugDuplicateError.classList.remove('hidden'); // Hiện thông báo lỗi
                    } else {
                        slugDuplicateError.classList.add('hidden'); // Ẩn thông báo lỗi
                    }
                }
            };
            xhr.send();
        });


        // Add change event listener to all form elements
        form.addEventListener("change", () => {
            formChanged = true;
        });

        // Add confirmation before leaving page
        window.addEventListener("beforeunload", (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue =
                    "Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời đi?";
            }
        });

        // Loading state for submit button
        form.addEventListener("submit", (e) => {
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang cập nhật...`;
        });
        // SEO Preview
        const seoTitleInput = document.getElementById("seo_title");
        const seoDescriptionInput = document.getElementById("seo_description");

        // Update SEO Preview
        function updateSEOPreview() {
            const titlePreview = document.getElementById("seoPreviewTitle");
            const descriptionPreview = document.getElementById("seoPreviewDescription");
            const slugPreview = document.getElementById("seoPreviewSlug");

            // Update title
            seoTitleInput.addEventListener("input", function() {
                titlePreview.textContent = this.value || "SEO Title Preview";
            });

            // Update description
            seoDescriptionInput.addEventListener("input", function() {
                descriptionPreview.textContent =
                    this.value || "SEO Description Preview";
            });

            // Update slug
            document.getElementById("slug").addEventListener("input", function() {
                slugPreview.textContent = this.value;
            });
        }

        // Initialize SEO Preview
        document.addEventListener("DOMContentLoaded", function() {
            updateSEOPreview();
        });

        // Character count for SEO fields
        function addCharacterCount(input, maxLength) {
            const wrapper = input.parentElement;
            const counter = document.createElement("div");
            counter.className = "text-sm text-gray-500 mt-1";
            wrapper.appendChild(counter);

            function updateCounter() {
                const remaining = maxLength - input.value.length;
                counter.textContent = `${input.value.length}/${maxLength} ký tự`;
                counter.className = `text-sm mt-1 ${
            remaining < 0 ? "text-red-500" : "text-gray-500"
        }`;
            }

            input.addEventListener("input", updateCounter);
            updateCounter();
        }

        // Add character counters
        addCharacterCount(seoTitleInput, 60);
        addCharacterCount(seoDescriptionInput, 160);

        function previewFile() {
            const file = document.getElementById('image').files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
