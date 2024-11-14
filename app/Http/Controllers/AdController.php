<?php

namespace App\Http\Controllers;

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
        // $ads = Ad::all();
        // Log::info('Retrieved all ads');


        $query = Ad::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ads = $query->paginate(5); // 5 quảng cáo mỗi trang

        return view('admin.ads.index', compact('ads'));
        // return AdResource::collection($ads);
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
    public function store(Request $request)
    {
        // Xác thực đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Kiểm tra file ảnh
            'url' => 'required|url',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',  // Kiểm tra ngày kết thúc
        ]);

        // Xử lý ảnh (upload)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ads', 'public');
        }

        // Lưu quảng cáo vào cơ sở dữ liệu
        $ad = new Ad();
        $ad->title = $request->title;
        $ad->image = $imagePath ?? null;  // Gán đường dẫn ảnh nếu có
        $ad->url = $request->url;
        $ad->position = $request->position;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->status = $request->status ?? 1; // Mặc định kích hoạt nếu không có status
        $ad->save();

        // Trả về kết quả
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
    public function edit(string $id)
    {
        // Tìm quảng cáo theo ID
        $ad = Ad::findOrFail($id);
        if (!$ad) {
            return redirect()->route('ads.index')->with('error', 'Quảng cáo không tồn tại!');
        }
        // Trả về view chỉnh sửa, truyền dữ liệu quảng cáo
        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Xác thực đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Kiểm tra file ảnh (nếu có thay đổi)
            'url' => 'required|url',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',  // Kiểm tra ngày kết thúc
        ]);
    
        // Tìm quảng cáo theo ID
        $ad = Ad::findOrFail($id);
    
        // Xử lý ảnh (nếu có thay đổi)
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($ad->image && file_exists(storage_path('app/public/' . $ad->image))) {
                unlink(storage_path('app/public/' . $ad->image));
            }
            // Upload ảnh mới
            $imagePath = $request->file('image')->store('ads', 'public');
            $ad->image = $imagePath;
        }
    
        // Cập nhật các trường khác
        $ad->title = $request->title;
        $ad->url = $request->url;
        $ad->position = $request->position;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->status = $request->status ?? 1; // Mặc định kích hoạt nếu không có status
    
        // Lưu thay đổi
        $ad->save();
    
        // Trả về kết quả
        return redirect()->route('ads.index')->with('success', 'Quảng cáo đã được cập nhật thành công!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
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
