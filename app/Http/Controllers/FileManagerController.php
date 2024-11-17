<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $files = Storage::disk('public')->files('images/posts');
        $fileUrls = [];

        foreach ($files as $file) {
            $fileUrls[] = asset('storage/' . $file);
        }

        return view('filemanager.index', compact('fileUrls'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            if ($file->isValid()) {
                $today = date('d-m-Y');
                $path = $file->storeAs("images/posts/$today", $file->getClientOriginalName(), 'public');
                $publicUrl = asset('storage/' . $path);

                return response()->json([
                    'fileName' => $file->getClientOriginalName(),
                    'uploaded' => 1,
                    'url' => $publicUrl,
                ]);
            }
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Không có tệp nào được tải lên']
        ]);
    }
}
