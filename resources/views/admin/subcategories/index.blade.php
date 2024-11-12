@extends('admin.layout')

@section('content')
<!-- Dashboard Navigation -->
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
    {{ $subcategories->links() }}
        <li>
            <div class="flex items-center">
                <span class="text-sm font-medium">/</span>
                <span class="ml-2 text-sm font-medium text-gray-700">Quản lý danh mục con</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Action Buttons -->
<div class="flex items-center mb-4">
    <a href="{{ route('subcategories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
        <i class="fas fa-plus"></i> Thêm mới
    </a>

    <div class="flex items-center border rounded overflow-hidden ml-2">
        <form action="{{ route('subcategories.index') }}" method="GET" class="flex items-center">
            <input name="search" class="px-4 py-2" placeholder="Tìm kiếm" type="text" value="{{ request()->get('search') }}" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Bảng danh mục con -->
<div class="overflow-x-auto">
    @if($subcategories->isEmpty())
    <p class="text-gray-500 text-center">Không có danh mục con nào được tìm thấy.</p>
    @else
    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="px-6 py-3 text-center font-semibold">STT</th>
                <th class="px-6 py-3 text-left font-semibold">Tên Danh Mục Con</th>
                <th class="px-6 py-3 text-left font-semibold">Danh Mục Cha</th>
                <th class="px-6 py-3 text-center font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subcategories as $index => $subcategory)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $subcategory->name }}</td>
                <td class="px-6 py-4">{{ $subcategory->category->name }}</td>
                <td class="px-6 py-4 text-center space-x-3">
                    <!-- Nút chỉnh sửa -->
                    <a href="{{ route('subcategories.edit', Crypt::encryptString($subcategory->id)) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>

                    <!-- Nút xóa -->
                    <form action="{{ route('subcategories.destroy', Crypt::encryptString($subcategory->id)) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $subcategories->links() }}
    </div>
    @endif
</div>

<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa danh mục con đã chọn không?');
    }
</script>
@endsection
