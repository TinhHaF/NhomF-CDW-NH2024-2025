<!-- resources/views/admin/subcategories/create.blade.php -->
@extends('admin.layout')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Thêm Danh Mục Con Mới</h2>
                    <a href="{{ route('subcategories.index') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 transition-colors">
                        ← Quay lại
                    </a>
                </div>

                @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('subcategories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Chọn danh mục cha -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Danh mục cha <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror"
                            required>
                            <option value="">Chọn danh mục cha</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tên danh mục con -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Tên danh mục con <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}"
                            placeholder="Nhập tên danh mục con"
                            required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mô tả danh mục con -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Mô tả
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nhập mô tả cho danh mục con">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                    <button type="reset"
                        class="flex items-center bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2 mb-2 md:mb-0 hover:bg-gray-400"
                        onclick="confirmReset()">
                        <i class="fas"></i>Làm Mới
                    </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Thêm danh mục con
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
