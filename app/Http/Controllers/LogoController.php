<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function showUploadForm()
    {
        $logo = Logo::latest()->first();
        $logoPath = $logo ? $logo->path : null;
        return view('admin.logo.upload', compact('logoPath'));
    }
    public function upload(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Kiểm tra nếu file là hình ảnh hợp lệ
            if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                // Tiến hành lưu tệp
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->store('logos', $filename, 'public'); // Lưu vào thư mục logos

                Logo::create(['path' => $path]);

                return back()->with('success', 'Logo đã được tải lên thành công!');
            }
            return back()->with('error', 'Tệp không phải là hình ảnh hợp lệ.');
        }
        return back()->with('error', 'Không có tệp logo nào được tải lên.');
    }
    public function delete($id)
    {
        // Tìm và xóa logo từ cơ sở dữ liệu
        $logo = Logo::find($id);
        // Storage::delete('public/' . $logo->path);
        $logo->delete();

        return back()->with('success', 'Logo đã được xóa thành công!');
    }
}
