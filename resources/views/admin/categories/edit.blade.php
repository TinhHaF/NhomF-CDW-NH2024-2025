@extends('admin.layout')

@section('content')
<form action="{{ route('categories.update', Crypt::encryptString($category->id)) }}" method="POST">
<div class="py-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Chỉnh sửa danh mục</h2>

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Chỉ cần một form duy nhất -->
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Tên danh mục
                            </label>
                            <input type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $category->name) }}"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Mô tả
                            </label>
                            <textarea name="description"
                                id="description"
                                rows="4"
                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('categories.index') }}"
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