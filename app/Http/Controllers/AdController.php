<?php

namespace App\Http\Controllers;

use App\Helpers\IdEncoder_2;
use App\Http\Requests\AdStoreRequest;
use App\Http\Requests\AdUpdateRequest;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ad::query()->latest();

        // Lọc theo từ khóa tìm kiếm (title)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái (status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo vị trí (position) nếu có
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Lấy kết quả với phân trang (5 quảng cáo mỗi trang)
        $ads = $query->paginate(5);

        // Trả về view với dữ liệu quảng cáo
        return view('admin.ads.index', compact('ads'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdStoreRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Xác định thư mục lưu file
        $destinationPath = public_path('upload/ad');

        // Tạo tên file mới để tránh trùng
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

        // Di chuyển file vào thư mục chỉ định
        $request->file('image')->move($destinationPath, $imageName);

        // Lưu thông tin vào database
        Ad::create([
            'title' => $request->title,
            'image' => 'upload/ad/' . $imageName, // Đường dẫn tương đối
            'url' => $request->url,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('ads.index')->with('success', 'Quảng cáo đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ad = Ad::findOrFail($id); // Tìm quảng cáo theo ID

        return view('admin.ads.show', compact('ad')); // Trả về view chi tiết
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encodedId)
    {
        try {
            
            // Validate và giải mã ID
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            // Giải mã ID và tìm quảng cáo theo ID
            $id = IdEncoder_2::decode($encodedId);
            $ad = Ad::findOrFail($id);

            // Trả về view chỉnh sửa, truyền dữ liệu quảng cáo
            return view('admin.ads.edit', compact('ad'));
        } catch (\Exception $e) {
            Log::error('Error loading edit post form', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Có lỗi xảy ra khi tải form chỉnh sửa.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encodedId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'required|url',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Giải mã ID
        $id = IdEncoder_2::decode($encodedId);
        $ad = Ad::findOrFail($id);

        // Xử lý ảnh nếu có thay đổi
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            $oldImagePath = public_path($ad->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Lưu ảnh mới
            $destinationPath = public_path('upload/ad');
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $imageName);

            $ad->image = 'upload/ad/' . $imageName;
        }

        // Cập nhật các thông tin khác
        $ad->update([
            'title' => $request->title,
            'url' => $request->url,
            'position' => $request->position,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('ads.index')->with('success', 'Quảng cáo đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encodedId)
    {
        // Giải mã ID
        $id = IdEncoder_2::decode($encodedId);

        // Tìm quảng cáo theo ID
        $ad = Ad::findOrFail($id);

        // Xóa ảnh (nếu có)
        if ($ad->image && file_exists(storage_path('app/public/' . $ad->image))) {
            unlink(storage_path('app/public/' . $ad->image));
        }

        // Xóa quảng cáo khỏi cơ sở dữ liệu
        $ad->delete();

        // Trả về kết quả
        return redirect()->route('ads.index')->with('success', 'Quảng cáo đã được xóa thành công!');
    }
}
