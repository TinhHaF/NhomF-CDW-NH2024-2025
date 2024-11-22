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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    {{--
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free-6.6.0-web/css/all.min.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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








        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background-color: rgba(255, 255, 255, 0.7);
            width: 100px;
            height: 100px;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="p-4">
                <img alt="Lacoly Logo" class="mx-auto" height="50" width="150"
                    src="{{ asset('images/logo.jpg') }}" />
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
                            {{-- <i class="fa-solid fa-chevron-up ml-auto"></i> --}}
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
                        {{-- <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                Danh mục
                            </li>
                        </ul> --}}
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
                        <li class="px-4 py-2 hover:bg-gray-200">
                            <a class="flex items-center hover:text-red-500" href="{{ route('author-requests') }}">
                                <i class="fa-solid fa-comments mr-2"></i>
                                Cấp Quyền Tác Gỉa
                            </a>
                        </li>
                    @endif
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="{{ route('logo.upload') }}">
                            <i class="fa-solid fa-images mr-2"></i>
                            Quản lý ảnh
                        </a>
                        {{-- <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                Logo
                            </li>
                        </ul> --}}
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="{{ route('ads.index') }}">
                            <i class="fa-solid fa-dumpster-fire mr-2"></i>
                            Quảng cáo
                        </a>
                        {{-- <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                Logo
                            </li>
                        </ul> --}}
                    </li>
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
            @include('components.notifications')

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
            filebrowserImageUploadUrl: '/filemanager/upload?_token={{ csrf_token() }}', // URL tải ảnh lên máy chủ
            filebrowserImageBrowseUrl: '/filemanager?type=Images', // URL duyệt ảnh từ máy chủ
            filebrowserBrowseUrl: '/filemanager?type=Files', // URL duyệt các tệp khác
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token={{ csrf_token() }}' // URL tải các tệp khác lên máy chủ
        });
        CKEDITOR.on('instanceReady', function(ev) {
            var editor = ev.editor;
            editor.on('notificationShow', function(evt) {
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


    <link href = "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel = "stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
