@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Trình quản lý tệp tin</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Tên tệp</th>
                <th>URL</th>
                <th>Ngày tải lên</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr>
                <td>{{ basename($file) }}</td>
                <td><a href="{{ Storage::disk('public')->url($file) }}" target="_blank">{{ basename($file) }}</a></td>
                <td>{{ date('d-m-Y', filemtime(storage_path('app/public/' . $file))) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection