@extends('admin.layout')
@section('content')
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                <th class="px-6 py-3 text-left">Người Dùng</th>
                <th class="px-6 py-3 text-left">Bút Danh</th>
                <th class="px-6 py-3 text-left">Tiểu Sử</th>
                <th class="px-6 py-3 text-center">Hành Động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $request->user->username }}</td>
                    <td class="px-6 py-4">{{ $request->pen_name }}</td>
                    <td class="px-6 py-4">{{ $request->biography }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <form method="POST" action="/admin/author-requests/{{ $request->id }}/approve">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    Chấp Nhận
                                </button>
                            </form>
                            <form method="POST" action="{{ route('author-rejectRequest', $request->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Từ Chối
                                </button>
                            </form>




                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection