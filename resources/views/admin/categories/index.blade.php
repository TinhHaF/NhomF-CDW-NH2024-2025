@extends('admin.layout')

@section('content')
<!-- Dashboard Navigation -->
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        <li>
            <div class="flex items-center">
                <a href="#" class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-700">Bảng điều
                    khiển</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <span class="text-sm font-medium">/</span>
                <span class="ml-2 text-sm font-medium text-gray-700">Quản lý tin tức</span>
            </div>
        </li>
    </ol>
</nav>

<!-- Action Buttons -->
<div class="flex items-center mb-4">
    <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
        <i class="fas fa-plus"></i> Thêm mới
    </a>

    <div class="flex items-center border rounded overflow-hidden ml-2">
        <form action="{{ route('categories.index') }}" method="GET" class="flex items-center">
            <input name="search" class="px-4 py-2" placeholder="Tìm kiếm" type="text" value="{{ request()->get('search') }}" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Bảng danh mục -->
<div class="overflow-x-auto">
    @if($categories->isEmpty())
    <p class="text-gray-500 text-center">Không có danh mục nào được tìm thấy.</p>
    @else
    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="px-6 py-3 text-center font-semibold">STT</th>
                <th class="px-6 py-3 text-left font-semibold">Tên Danh Mục</th>
                <th class="px-6 py-3 text-center font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $category->name }}</td>
                <td class="px-6 py-4 text-center space-x-3">
                    <!-- Nút chỉnh sửa -->
                    <a href="{{ route('categories.edit', Crypt::encryptString($category->id)) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>

                    <!-- Nút xóa -->
                    <form action="{{ route('categories.destroy', Crypt::encryptString($category->id)) }}" method="POST" style="display:inline;">
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
        {{ $categories->links() }}  <!-- Hiển thị các liên kết phân trang -->
    </div>
    @endif
</div>
</div>
</div>

<script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa danh mục đã chọn không?');
    }
</script>
@endsection