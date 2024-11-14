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
    protected $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

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
    public function store(AdStoreRequest $request)
    {
        $ad = $this->adService->createAd($request->validated());
        Log::info('Ad created', ['ad_id' => $ad->id]);

        // Thêm thông báo vào session
        session()->flash('success', 'Quảng cáo đã được tạo thành công!');

        // Điều hướng về trang danh sách quảng cáo
        return redirect()->route('ads.index');
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
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        // Cập nhật quảng cáo với dữ liệu hợp lệ từ form
        $ad = $this->adService->updateAd($ad, $request->validated());
        Log::info('Ad updated', ['ad_id' => $ad->id]);

        // Thêm thông báo vào session
        session()->flash('success', 'Quảng cáo đã được cập nhật thành công!');

        return new AdResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        try {
            $this->adService->deleteAd($ad);
            Log::info('Ad deleted', ['ad_id' => $ad->id]);

            // Thêm thông báo vào session
            session()->flash('success', 'Quảng cáo đã được xóa thành công!');

            return redirect()->route('ads.index');
        } catch (\Exception $e) {
            Log::error('Error deleting ad', ['error' => $e->getMessage()]);
            return redirect()->route('ads.index')->with('error', 'Không thể xóa quảng cáo.');
        }
    }
}
