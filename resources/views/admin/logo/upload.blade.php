@extends('admin.layout')
@section('content')

    <body class="bg-gray-100">
        <div class="container mx-auto p-2 sm:p-4">
            <div class="text-xs sm:text-sm text-gray-500 mb-6 sm:mb-0">
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
                            <span class="ml-2 text-sm font-medium text-gray-700">Quản lý hình ảnh - video</span>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mb-4">
                <div class="space-x-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded text-xs sm:text-base">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                    <button type="reset" class="bg-gray-500 text-white px-4 py-2 rounded text-xs sm:text-base">
                        <i class="fas fa-redo"></i> Làm lại
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-md rounded p-4 border-t-4 border-blue-500">
                <div class="mb-4 border-b">
                    <h2 class="text-base sm:text-lg font-semibold">Chi tiết Logo</h2>
                </div>

                <form action="{{ route('logo.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Upload hình ảnh -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 mb-2 text-sm sm:text-base">Upload hình ảnh:</label>
                        <div class="w-1/2 border border-gray-300 rounded p-2 sm:p-4 flex justify-center items-center mb-2">
                            <img src="{{ asset($logoPath) }}"
                                alt="Logo" id="logoPreview" style="width: 300px; height: 300px;">
                        </div>

                        <input type="file" name="logo" id="image" class="hidden" accept="image/*"
                            onchange="previewFile()">
                        @error('logo')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <button type="button" onclick="document.getElementById('image').click()"
                            class="bg-green-500 text-white px-4 py-2 rounded">
                            <i class="fas fa-camera mr-2"></i>Chọn hình
                        </button>
                    </div>

                    <div class="text-black-600 text-xs text-bold sm:text-sm mb-4">
                        Width: 370 px - Height: 90 px (.jpg|.gif|.png|.jpeg)
                    </div>

                    <!-- Hiển thị logo -->
                    <div class="mb-4">
                        <label class="block text-black-700 mb-2 text-sm sm:text-base">Hiển thị:</label>
                        <input type="checkbox" name="visible" class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-blue-600"
                            checked onchange="toggleLogoVisibility(this)">
                    </div>

                    <!-- Button group -->
                    <div class="flex justify-start space-x-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-xs sm:text-base">
                            <i class="fas fa-save"></i> Lưu
                        </button>
                        <button type="reset" class="bg-gray-500 text-white px-4 py-2 rounded text-xs sm:text-base">
                            <i class="fas fa-redo"></i> Làm lại
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview image script -->
        <script>
            function previewFile() {
                const preview = document.getElementById('logoPreview');
                const file = document.getElementById('image').files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "{{ asset('uploads/logos/' . $logoPath) }}";
                }
            }

            function setDefaultImage() {
                const preview = document.getElementById("logoPreview");
                if (preview) {
                    preview.src = "/images/no-image-available.jpg";
                }
            }

            // function toggleLogoVisibility(checkbox) {
            //     const preview = document.getElementById('logoPreview');
            //     // Check if the checkbox is checked
            //     if (checkbox.checked) {
            //         preview.style.display = 'block'; // Show the image
            //     } else {
            //         preview.style.display = 'none'; // Hide the image
            //     }
            // }

            // Initial image visibility check
            if (!'{{ $logoPath }}') {
                setDefaultImage();
            }
        </script>

    </body>
@endsection
