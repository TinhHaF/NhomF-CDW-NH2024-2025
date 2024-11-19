@extends('admin.layout')
@section('content')

<body>
    <div class="m-4">
        <!-- Dashboard Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                <li>
                    <a href="#" class="text-blue-600 hover:text-blue-700">Bảng điều khiển</a>
                </li>
                <li>/</li>
                <li>Quản lý Người dùng</li>
            </ol>
        </nav>

        <!-- Action Buttons -->
        <div class="flex items-center mb-6">
            <a href="{{ route('users.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md mr-4 shadow">
                <i class="fas fa-plus mr-2"></i>Thêm mới
            </a>
            <form action="" method="POST" id="bulkDeleteForm" class="inline">
                @csrf
                <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-md shadow"
                    onclick="bulkDeleteSystem.confirmDelete()">
                    <i class="fas fa-trash mr-2"></i>Xóa tất cả (<span id="selectedCount">0</span>)
                </button>
            </form>
            <form action="{{ route('users.index') }}" method="GET" class="flex items-center ml-auto">
                <input name="search" type="text" placeholder="Tìm kiếm" value="{{ request()->get('search') }}"
                    class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto border rounded-md shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 text-gray-600">
                    <tr class="text-sm uppercase font-semibold tracking-wider">
                        <th class="px-6 py-4 text-center">
                            <input type="checkbox" id="selectAll"
                                class="rounded border-gray-300 text-blue-600 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-center">STT</th>
                        <th class="px-6 py-4 text-left">Tên Người Dùng</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Avatar</th>
                        <th class="px-6 py-4 text-center">Ngày Tạo</th>
                        <th class="px-6 py-4 text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr class="border-b hover:bg-gray-100 transition duration-200">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox"
                                    class="userCheckbox rounded border-gray-300 text-blue-600 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 text-center">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->username ?? 'Avatar' }}"
                                        class="w-10 h-10 rounded-full border">
                                @else
                                    <img src="{{ asset('user_avt/avt.jpg') }}" alt="Default Avatar"
                                        class="w-10 h-10 rounded-full border">
                                @endif

                            </td>
                            <td class="px-6 py-4 text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{  route('user_view', ['id' => $user->id]) }}" title="Xem người dùng"
                                        class="text-blue-500 hover:text-blue-600">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" title="Sửa người dùng"
                                        class="text-green-500 hover:text-green-600">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Xóa người dùng" class="text-red-500 hover:text-red-600"
                                            style="background: none; border: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="p-4 bg-white border-t">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</body>
@endsection