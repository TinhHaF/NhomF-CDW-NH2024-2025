@extends('admin.layout')

@section('content')
    @php
        use App\Helpers\IdEncoder_2;
    @endphp
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
                </ol>
            </nav>
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Quản Lý Quảng Cáo</h1>
                    <p class="mt-2 text-sm text-gray-600">Quản lý tất cả quảng cáo trong hệ thống</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('ads.create') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Thêm Quảng Cáo Mới
                    </a>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-4">
                <div class="p-6">
                    <form method="GET" action="{{ route('ads.index') }}"
                        class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request()->search }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Tìm kiếm theo tiêu đề...">
                            </div>
                        </div>

                        <div class="sm:w-48">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                            <select id="status" name="status"
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Vô hiệu</option>
                            </select>
                        </div>

                        <div class="sm:w-48">
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Vị trí</label>
                            <select id="position" name="position"
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Tất cả vị trí</option>
                                <option value="header" {{ request()->position == 'header' ? 'selected' : '' }}>Header
                                </option>
                                <option value="sidebar" {{ request()->position == 'sidebar' ? 'selected' : '' }}>Sidebar
                                </option>
                                <option value="footer" {{ request()->position == 'footer' ? 'selected' : '' }}>Footer
                                </option>
                                <option value="content" {{ request()->position == 'content' ? 'selected' : '' }}>Content
                                </option>
                            </select>
                        </div>

                        <div class="sm:flex sm:items-end">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Lọc kết quả
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quảng cáo
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vị trí
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Trạng thái
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Thời gian
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ads as $ad)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-lg object-cover"
                                                    src="{{ asset($ad->image) }}" alt="{{ $ad->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $ad->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ Str::limit($ad->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($ad->position) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ad->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ad->status ? 'Kích hoạt' : 'Vô hiệu' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>Bắt đầu: {{ $ad->start_date->format('Y-m-d') }}</div>
                                        <div>Kết thúc: {{ $ad->end_date->format('Y-m-d') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('ads.edit', $encodedId = IdEncoder_2::encode($ad->id)) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="h-4 w-4 text-gray-500 mr-1.5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Sửa
                                            </a>
                                            <form
                                                action="{{ route('ads.destroy', $encodedId = IdEncoder_2::encode($ad->id)) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa quảng cáo này?')"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="h-4 w-4 text-red-500 mr-1.5" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $ads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
