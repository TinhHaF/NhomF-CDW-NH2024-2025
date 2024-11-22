<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoController extends Controller
{
    public function showUploadForm()
    {
        $logo = Logo::latest()->first();
        $logoPath = $logo ? $logo->path : 'images/logo.jpg';
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
                // Tạo tên tệp duy nhất
                $filename = time() . '_' . $file->getClientOriginalName();

                // Đường dẫn lưu tệp vào public/upload/logos/
                $destinationPath = public_path('upload/logos');
                $file->move($destinationPath, $filename);

                // Lưu đường dẫn vào database (nếu cần)
                Logo::create(['path' => 'upload/logos/' . $filename]);

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
