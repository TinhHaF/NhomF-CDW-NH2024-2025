<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> <!-- Thêm CKEditor 4 từ CDN -->
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/5 bg-white h-auto md:h-screen shadow-md">
            <div class="p-4">
                <div class="text-center mb-4">
                    <div class="text-lg font-bold">Logo</div>
                </div>
                <div class="border-t border-b py-2">
                    <div class="text-center font-semibold">Bảng điều khiển</div>
                </div>
                <div class="py-2">
                    <div class="font-semibold">Quản lý bài viết</div>
                    <div class="pl-4">
                        <div class="py-1">Tin tức</div>
                        <div class="py-1">Danh Mục</div>
                    </div>
                </div>
                <div class="py-2">
                    <div class="font-semibold">Quản lý người dùng</div>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="w-full md:w-4/5 p-4">
            <div class="flex justify-between items-center mb-4 border-b p-2">
                <div class="flex items-center">
                    <i class="fas fa-bars mr-2"></i>
                    <span class="font-semibold">Xin chào, admin</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-cog mr-4"></i>
                    <i class="fas fa-bell mr-4"></i>
                    <button class="font-semibold">Đăng xuất</button>
                </div>
            </div>
            <div class="mb-4">
                <span class="text-blue-600 font-semibold">Bảng điều khiển</span> / Thêm mới tin tức
            </div>
            <div class="flex flex-col md:flex-row mb-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0">Lưu</button>
                <button class="bg-blue-400 text-white px-4 py-2 rounded mr-2 mb-2 md:mb-0">Làm Lại</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded">Thoát</button>
            </div>
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3">
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Tiêu đề</label>
                        <input type="text" class="h-8 border-2 w-max">
                    </div>
                    <div>
                        <label class="block font-semibold mb-2">Nội Dung</label>
                        <textarea name="content" id="editor"></textarea> <!-- Phần tử textarea cho CKEditor -->
                    </div>
                </div>
                <div class="w-full md:w-1/3 pl-0 md:pl-4 mt-4 md:mt-0">
                    <!-- Chọn Danh Mục -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Chọn Danh Mục</label>
                        <select class="bg-white border rounded p-2 w-full">
                            @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4">
                        <label class="block font-semibold mb-2">Hình ảnh Tin tức</label>
                        <div class="bg-gray-200 border rounded p-4 text-center">
                            <img alt="No image available" class="mx-auto mb-4" height="205" src="https://storage.googleapis.com/a1aa/image/eOy54R9t52yUeka2MwKYJsf7KVemXDYQ8a2EyUh6lecKlqAdC.jpg" width="360" />
                            <div class="bg-gray-100 border-dashed border-2 border-gray-400 p-4">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                <p>Kéo và thả hình vào đây</p>
                                <p>hoặc</p>
                                <button class="bg-green-500 text-white px-4 py-2 rounded">Chọn hình</button>
                            </div>
                            <p class="text-xs mt-2">Width: 360 px - Height: 205 px (.jpg, .gif, .png, .jpeg, .gif)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Khởi tạo CKEditor 4 cho phần tử textarea với id "editor"
        CKEDITOR.replace('editor');
    </script>
</body>

</html>