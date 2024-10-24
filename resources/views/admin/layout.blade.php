<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Admin Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> <!-- Thêm CKEditor 4 từ CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Đặt jQuery ở đây, trong thẻ <head> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-56 bg-white shadow-md">
    <div class="p-4">
        <img alt="Lacoly Logo" class="mx-auto" height="50" 
             src="https://storage.googleapis.com/a1aa/image/tkMOcGFkfmyvdq3JhGQHzAhhaTpAVYMnMUGYFRdsJEfj28nTA.jpg" 
             width="150" />
    </div>
    <nav class="mt-6">
        <ul>
            <li class="px-4 py-2 hover:bg-gray-200">
                <a class="flex items-center hover:text-red-500" href="#">
                    <i class="fas fa-tachometer-alt mr-2"></i> Bảng điều khiển
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-gray-200">
                <a class="flex items-center hover:text-red-500" href="#">
                    <i class="fas fa-home mr-2"></i> Nội dung trang chủ
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-gray-200">
                        <!-- Thêm sự kiện onclick cho icon dropdown -->
                        <a class="flex items-center hover:text-red-500 cursor-pointer" data-toggle="dropdown">
                            <i class="fas fa-newspaper mr-2"></i>
                            Quản lý bài viết
                            <i class="fas fa-chevron-up ml-auto"></i> <!-- Thêm icon để chỉ ra dropdown -->
                        </a>
                        <ul class="ml-6 mt-2 hidden"> <!-- Ban đầu ẩn -->
                            <li class="px-4 py-2 bg-blue-100">
                                <!-- Điều hướng thông thường -->
                                <a class="flex items-center hover:text-red-500" href="{{ route('posts.create') }}">
                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </li>
            <li class="px-4 py-2 bg-gray-200">
                <a class="flex items-center hover:text-red-500" href="#">
                    <i class="fas fa-newspaper mr-2"></i> Quản lý danh mục
                </a>
                <ul class="ml-6 mt-2">
                    <li class="px-4 py-2 bg-blue-100">
                        <a class="flex items-center hover:text-red-500" href="#">Danh mục</a>
                    </li>
                </ul>
            </li>
            
            {{-- Kiểm tra nếu role của người dùng là 2, hiển thị "Quản lý người dùng" --}}
            @if (Auth::user()->role == 2)
                <li class="px-4 py-2 hover:bg-gray-200">
                    <a class="flex items-center hover:text-red-500" href="#">
                        <i class="fas fa-users mr-2"></i> Quản lý người dùng
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>

        <!-- Main Content -->
        <div class="flex-grow">
            <div class="flex justify-between items-center mb-4 border-b p-4 bg-white text-[#adacad]">
                <div class="flex items-center">
                    <i class="fas fa-bars mr-2"></i>
                    <span class="font-semi">Xin chào, admin</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-cog mr-4"></i>
                    <i class="fas fa-bell mr-4"></i>
                    <button class="font-semi">Đăng xuất</button>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Khởi tạo CKEditor 4 cho phần tử textarea với id "editor"
        CKEDITOR.replace('editor');

        toastr.options.positionClass = 'toast-top-right'; // Vị trí bên phải
        toastr.options.timeOut = 3000; // Thời gian hiển thị (3 giây)
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
