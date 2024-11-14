<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    // Phương thức để duyệt ảnh từ máy chủ
    public function index(Request $request)
    {
        // Lấy danh sách các ảnh trong thư mục 'images' (hoặc thư mục khác mà bạn cấu hình)
        $files = Storage::files('images');

        // Trả về view chứa danh sách các ảnh để CKEditor có thể duyệt
        return view('filemanager.index', compact('files'));
    }

    // Phương thức để tải ảnh lên máy chủ
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Kiểm tra tệp hợp lệ
            if ($file->isValid()) {
                // Lưu ảnh vào thư mục 'images'
                $path = $file->store('images');

                // Trả về URL của ảnh đã tải lên
                return response()->json([
                    'fileName' => $file->getClientOriginalName(),
                    'uploaded' => 1,
                    'url' => Storage::url($path),  // Trả về URL đầy đủ của ảnh đã tải lên
                ]);
            }
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Không có tệp nào được tải lên']
        ]);
    }
}
