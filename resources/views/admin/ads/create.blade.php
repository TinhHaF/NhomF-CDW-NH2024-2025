@extends('admin.layout')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-200 to-white py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                                class="block w-full pr-10 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="Nhập tiêu đề quảng cáo">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Upload Section -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Hình ảnh quảng cáo</label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-200">
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
                                                class="block w-full pl-10 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="https://example.com">
                                        </div>
                                    </div>

                                    <!-- Position Selection -->
                                    <div>
                                        <label for="position" class="block text-sm font-medium text-gray-700">
                                            Vị trí hiển thị
                                        </label>
                                        <select id="position" name="position"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
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
                                        <div class="mt-1">
                                            <div class="relative inline-block w-full">
                                                <select id="status" name="status"
                                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                                                    <option value="1">Kích hoạt</option>
                                                    <option value="0">Vô hiệu</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Section -->
                            <div class="pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Lịch trình hiển thị</h3>
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                                            Ngày bắt đầu
                                        </label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="date" name="start_date" id="start_date"
                                                class="block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                                            Ngày kết thúc
                                        </label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="date" name="end_date" id="end_date"
                                                class="block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-8 border-t border-gray-200 mt-8">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="window.history.back()"
                                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Hủy bỏ
                                </button>
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Lưu quảng cáo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript to preview the image -->
    <script>
        function previewImage(event) {
            const fileInput = event.target;
            const preview = document.getElementById('image-preview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Show the preview image
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
@endsection
