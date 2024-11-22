@extends('admin.layout')

@section('content')
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
                            <span class="ml-2 text-sm font-medium text-gray-700">Quảng cáo</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="text-sm font-medium">/</span>
                            <span class="ml-2 text-sm font-medium text-gray-700">Thêm mới quảng cáo</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Thêm Mới Quảng Cáo</h1>
                    <p class="mt-2 text-sm text-gray-600">Điền đầy đủ thông tin để tạo quảng cáo mới</p>
                </div>
                <a href="{{ route('ads.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Quay lại
                </a>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden text-sm p-2 border-t-4 border-blue-500">
                <div class="p-8">
                    <form action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin cơ bản</h3>
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Tiêu đề quảng cáo
                                        </label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="text" name="title" id="title"
                                                class="block w-full pr-10 border-2 p-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 placeholder-gray-500"
                                                placeholder="Nhập tiêu đề quảng cáo">
                                        </div>
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Hình ảnh quảng cáo</label>
                                        <div
                                            class="mt-1 flex justify-center px-6 py-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-200">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <!-- Image Preview -->
                                                <div class="mt-4">
                                                    <img id="image-preview" src="" alt="Image Preview"
                                                        class="max-h-64 rounded-md hidden" />
                                                </div>
                                                <div class="flex text-sm text-gray-600 justify-center pt-4">
                                                    <label for="file-upload"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Tải lên file</span>
                                                        <input id="file-upload" name="image" type="file"
                                                            class="sr-only" onchange="previewImage(event)">
                                                    </label>
                                                    <p class="pl-1">hoặc kéo thả</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 10MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- URL Input -->
                                    <div class="sm:col-span-2">
                                        <label for="url" class="block text-sm font-medium text-gray-700">
                                            Liên kết quảng cáo
                                        </label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                            </div>
                                            <input type="url" name="url" id="url"
                                                class="block w-full pl-10 border-2 p-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 placeholder-gray-500"
                                                placeholder="https://example.com">
                                        </div>
                                    </div>

                                    <!-- Position Selection -->
                                    <div>
                                        <label for="position" class="block text-sm font-medium text-gray-700">
                                            Vị trí hiển thị
                                        </label>
                                        <select id="position" name="position"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                                            <option value="header">Header</option>
                                            <option value="sidebar">Sidebar</option>
                                            <option value="footer">Footer</option>
                                            <option value="content">Content</option>
                                        </select>
                                    </div>

                                    <!-- Status Toggle -->
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">
                                            Trạng thái
                                        </label>
                                        <div class="relative inline-block w-full">
                                            <select id="status" name="status"
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                                                <option value="1">Kích hoạt</option>
                                                <option value="0">Vô hiệu</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Date Selection Section -->
                            <div class="space-y-8 mt-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                                            Ngày bắt đầu
                                        </label>
                                        <input type="date" id="start_date" name="start_date"
                                            class="mt-1 block w-full border-2 p-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                                            Ngày kết thúc
                                        </label>
                                        <input type="date" id="end_date" name="end_date"
                                            class="mt-1 block w-full border-2 p-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8 flex justify-end">
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    Lưu quảng cáo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cập nhật giá trị min cho trường ngày bắt đầu và kết thúc để không cho chọn ngày trong quá khứ
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').setAttribute('min', today);
            document.getElementById('end_date').setAttribute('min', today);
        });

        // Hàm hiển thị ảnh khi tải lên
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('image-preview');
                preview.src = reader.result;
                preview.classList.remove('hidden');
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
