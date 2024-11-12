<!-- resources/views/admin/subcategories/edit.blade.php -->
@extends('admin.layout')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Chỉnh sửa danh mục con</h2>

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('subcategories.update', Crypt::encryptString($subcategory->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Tên danh mục con -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Tên danh mục con
                            </label>
                            <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $subcategory->name) }}"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <!-- Mô tả danh mục con -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Mô tả
                            </label>
                            <textarea name="description"
                                id="description"
                                rows="4"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $subcategory->description) }}</textarea>
                        </div>

                        <!-- Chọn danh mục cha -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Danh mục cha
                            </label>
                            <select name="category_id"
                                id="category_id"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('subcategories.index') }}"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Hủy
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
