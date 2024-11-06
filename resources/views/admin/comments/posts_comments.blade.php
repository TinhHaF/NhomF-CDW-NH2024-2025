@extends('admin.layout')
@section('content')

<body>
    <div class="m-4">
        <!-- Dashboard Navigation -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a>
                </li>
                <li>/</li>
                <li><a class="text-blue-600 hover:text-blue-700">Bài Viết</a></li>
            </ol>
        </nav>

        <!-- Action Buttons -->
        <div class="flex items-center mb-6">
            <form action="{{ route('users.index') }}" method="GET" class="flex items-center ml-auto">
                @csrf
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
                        <th class="px-6 py-4 text-center">STT</th>
                        <th class="px-6 py-4 text-left">Ảnh</th>
                        <th class="px-6 py-4 text-left">Tiêu Đề</th>
                        <th class="px-6 py-4 ">Bình Luận</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $index => $post)
                    <tr class="border-b hover:bg-gray-100 transition duration-200 cursor-pointer"
                        onclick="window.location='{{ route('comments_index', ['id' => $post->id]) }}'">
                        <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Avatar" class="w-10 h-10 rounded-full border">
                            @else
                            <img src="{{ asset('path/to/default-avatar.png') }}" alt="Default Avatar" class="w-10 h-10 rounded-full border">
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ Str::limit($post->title, 50) }}</td>
                        <td class="px-6 py-4 text-center">{{ $post->comments_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="p-4 bg-white border-t">
                {{ $posts->links() }}
            </div>
        </div>

    </div>
</body>

@endsection