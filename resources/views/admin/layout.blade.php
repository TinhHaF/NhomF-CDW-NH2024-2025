<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="{{ $post->seo_title ?? '' }}">
    <meta name="description" content="{{ $post->seo_description ?? '' }}">
    <meta name="keywords" content="{{ $post->seo_keywords ?? '' }}">
    <title>
        Admin Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-6.6.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    {{--
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{--
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/highcharts.js') }}"></script>

    <style>
        /* Custom styles for the responsive menu */
        @media (max-width: 768px) {
            #sidebar {
                display: none;
            }

            #menu-toggle:checked+#sidebar {
                display: block;
            }
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 13px;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('components.notifications')
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="p-4">
                <img alt="Lacoly Logo" class="mx-auto" height="50"
                    src="https://storage.googleapis.com/a1aa/image/tkMOcGFkfmyvdq3JhGQHzAhhaTpAVYMnMUGYFRdsJEfj28nTA.jpg"
                    width="150" />
            </div>
            <nav class="mt-6">
                <ul class="space-y-2">
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-tachometer-alt mr-2"></i>
                            Bảng điều khiển
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="{{ route('home') }}">
                            <i class="fa-solid fa-home mr-2"></i>
                            Trang homepage
                        </a>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500 cursor-pointer" data-toggle="dropdown"
                            href="{{ route('posts.index') }}">
                            <i class="fa-solid fa-newspaper mr-2"></i>
                            Quản lý bài viết
                            <i class="fa-solid fa-chevron-up ml-auto"></i>
                        </a>
                        <ul class="ml-6 mt-2 hidden">
                            <li class="px-4 py-2 bg-blue-100">
                                <a class="flex items-center hover:text-red-500" href="{{ route('posts.index') }}">
                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="{{ route('categories.index') }}">
                            <i class="fa-solid fa-folder mr-2"></i>
                            Quản lý danh mục
                        </a>
                        <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                Danh mục
                            </li>
                        </ul>
                    </li>
                    @if (Auth::user()->role == 2)
                        <li class="px-4 py-2 hover:bg-gray-200">
                            <a class="flex items-center hover:text-red-500" href="{{ route('users.index') }}">
                                <i class="fa-solid fa-users mr-2"></i>
                                Quản lý người dùng
                            </a>
                        </li>
                        <li class="px-4 py-2 hover:bg-gray-200">
                            <a class="flex items-center hover:text-red-500" href="{{ route('PostsComment') }}">
                                <i class="fa-solid fa-comments mr-2"></i>
                                Quản lý Bình Luận
                            </a>
                        </li>

                    @endif
                </ul>
            </nav>
        </div>
        @php
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    @endphp
        <!-- Main Content -->
        <div class="flex-grow">
            <div class="flex justify-between items-center mb-4 border-b p-4 bg-white text-[#adacad]">
                <div class="flex items-center">
                    <i class="fa-solid fa-bars mr-2"></i>
                    <span> Xin Chào {{ $user->username }}</span>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('home') }}"><i class="fa-solid fa-house mr-4"></i></a>
                    <i class="fa-solid fa-cog mr-4"></i>
                    <i class="fa-solid fa-bell mr-4"></i>
                    <button class="font-semi" onclick="window.location.href='{{ route('user.logout') }}'">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Đăng xuất
                    </button>
                </div>
            </div>
            @yield('content')

        </div>
    </div>
    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Khởi tạo CKEditor 4 cho phần tử textarea với id "editor"
        CKEDITOR.replace('editor', {
            height: 400,
            removeButtons: 'PasteFromWord',
            //Cấu hình thêm cho CKEditor nếu cần
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token=',
        });
        CKEDITOR.on('instanceReady', function (ev) {
            var editor = ev.editor;
            editor.on('notificationShow', function (evt) {
                if (evt.data.message.indexOf('This CKEditor') !== -1) {
                    evt.cancel();
                }
            });
        });


        // tính số lượng bài viết được chọn để xóa
        const selectAllCheckbox = document.getElementById("selectAll"); // Lấy checkbox "Chọn tất cả"
        const itemCheckboxes = document.querySelectorAll(".selectItem"); // Lấy tất cả checkbox trong bảng
        const selectedCountSpan = document.getElementById("selectedCount"); // Lấy phần tử hiển thị số lượng đã chọn

        // Hàm cập nhật số lượng bài viết được chọn
        function updateSelectedCount() {
            const selectedCount = document.querySelectorAll(
                ".selectItem:checked"
            ).length; // Đếm số checkbox được chọn
            selectedCountSpan.textContent = selectedCount; // Cập nhật số lượng vào phần tử hiển thị
        }

        // Lắng nghe sự kiện thay đổi cho từng checkbox
        itemCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", updateSelectedCount); // Gọi hàm cập nhật khi checkbox thay đổi
        });

        // Lắng nghe sự kiện cho checkbox "Chọn tất cả" để cập nhật tất cả checkbox và số lượng
        selectAllCheckbox.addEventListener("click", function() {
            itemCheckboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox
                    .checked; // Đặt trạng thái checkbox theo trạng thái của "Chọn tất cả"
            });
            updateSelectedCount(); // Cập nhật số lượng đã chọn
        });
    </script>

    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
