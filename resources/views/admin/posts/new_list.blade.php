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
            <div class="p-4">
                <div class="flex items-center mb-4">
                    <span class="text-sm font-bold text-blue-600">
                        Bảng điều khiển
                    </span>
                    <span class="mx-2">
                        /
                    </span>
                    <span class="text-sm font-bold">
                        Quản lý tin tức
                    </span>
                </div>
                <div class="flex items-center mb-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
                        <i class="fas fa-plus">
                        </i>
                        Thêm mới
                    </button>
                    <button class="bg-red-500 text-white px-4 py-2 rounded mr-2">
                        <i class="fas fa-trash">
                        </i>
                        Xóa tất cả
                    </button>
                    <div class="flex items-center border rounded overflow-hidden">
                        <input class="px-4 py-2" placeholder="Tìm kiếm" type="text" />
                        <button class="bg-blue-500 text-white px-4 py-3">
                            <i class="fas fa-search">
                            </i>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto border">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="w-full p-4 text-sm border-b">
                                Danh sách Tin Tức
                            </tr>
                            <tr class="w-full p-4 text-sm border-b">
                                <th class="py-2 px-4">
                                    <input type="checkbox" />
                                </th>
                                <th class="py-2 px-4">
                                    STT
                                </th>
                                <th class="py-2 px-4">
                                    Hình
                                </th>
                                <th class="float-left py-2 px-4">
                                    Tiêu đề
                                </th>
                                <th class="py-2 px-4">
                                    Nổi bật
                                </th>
                                <th class="py-2 px-4">
                                    Hiển thị
                                </th>
                                <th class="py-2 px-4">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="text-center">
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" />
                                </td>
                                <td class="py-2 px-4 border-b">
                                    1
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <img alt="Placeholder image" height="50" src="https://storage.googleapis.com/a1aa/image/wp3zMUQgBc6XFtwv8xxunW5dDRtVjZvS9ecKvnIV06z4CG0JA.jpg" width="50" />
                                </td>
                                <td class="py-2 px-4 border-b text-left">
                                    <div>
                                        Điểm nhấn của các hệ thống và giải pháp phần mềm đáp ứng đổi mới sáng tạo
                                    </div>
                                    <div class="text-sm text-gray-500 mb-2">
                                        Ngày tạo: 22/05/2023
                                    </div>
                                    <div class="flex space-x-2">
                                        <a class="text-blue-500" href="#">
                                            <i class="fas fa-eye">
                                            </i>
                                            View
                                        </a>
                                        <a class="text-green-500" href="#">
                                            <i class="fas fa-edit">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="text-red-500" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" />
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <input type="checkbox" />
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <i class="fas fa-copy text-green-500 mr-2">
                                    </i>
                                    <i class="fas fa-edit text-green-500 mr-2">
                                    </i>
                                    <i class="fas fa-trash text-red-500">
                                    </i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>