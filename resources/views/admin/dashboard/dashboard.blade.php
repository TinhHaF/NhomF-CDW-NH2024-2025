<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Admin Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-56 bg-white shadow-md">
            <div class="p-4">
                <img alt="Lacoly Logo" class="mx-auto" height="50" src="https://storage.googleapis.com/a1aa/image/tkMOcGFkfmyvdq3JhGQHzAhhaTpAVYMnMUGYFRdsJEfj28nTA.jpg" width="150" />
            </div>
            <nav class="mt-6">
                <ul>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-tachometer-alt mr-2">
                            </i>
                            Bảng điều khiển
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-home mr-2">
                            </i>
                            Nội dung trang chủ
                        </a>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-box mr-2">
                            </i>
                            Quản lý Sản phẩm
                        </a>
                    </li>
                    <li class="px-4 py-2 bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-newspaper mr-2">
                            </i>
                            Quản lý bài viết
                        </a>
                        <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                <a class="flex items-center hover:text-red-500" href="#">

                                    Tin tức
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="px-4 py-2 bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-newspaper mr-2">
                            </i>
                            Quản lý danh mục
                        </a>
                        <ul class="ml-6 mt-2">
                            <li class="px-4 py-2 bg-blue-100">
                                <a class="flex items-center hover:text-red-500" href="#">

                                    Danh mục
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="px-4 py-2 hover:bg-gray-200">
                        <a class="flex items-center hover:text-red-500" href="#">
                            <i class="fas fa-users mr-2">
                            </i>
                            Quản lý người dùng
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="w-full md:w-5/5">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 bg-white shadow-md">
                <div class="flex items-center">
                    <button class="text-gray-500 text-sm mr-4">
                        <i class="fas fa-bars">
                        </i>
                    </button>
                    <span class="text-gray-700">
                        Xin chào, admin!
                    </span>
                </div>
                <div class="flex items-center text-gray-500">
                    <i class="fas fa-cog text-sm mr-4">
                    </i>
                    <i class="fas fa-bell text-sm mr-4">
                    </i>
                    <span class="text-sm">
                        Đăng xuất
                    </span>
                </div>
            </div>
            <!-- Content -->
            <div class="flex-1 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">
                        Dashboard
                    </h1>
                </div>
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="bg-orange-400 text-white p-4 rounded shadow">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-2">
                            </i>
                            <span>
                                Đang online
                            </span>
                        </div>
                        <div class="text-2xl font-bold">
                            1
                        </div>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded shadow">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2">
                            </i>
                            <span>
                                Truy cập tuần
                            </span>
                        </div>
                        <div class="text-2xl font-bold">
                            207
                        </div>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded shadow">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2">
                            </i>
                            <span>
                                Truy cập tháng
                            </span>
                        </div>
                        <div class="text-2xl font-bold">
                            802
                        </div>
                    </div>
                    <div class="bg-blue-500 text-white p-4 rounded shadow">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar mr-2">
                            </i>
                            <span>
                                Tổng truy cập
                            </span>
                        </div>
                        <div class="text-2xl font-bold">
                            28711
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">
                        Thống kê truy cập tháng 10/2024
                    </h2>
                    <div id="chart-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>