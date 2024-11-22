<?php

namespace App\Services;

use App\Models\Ad;

class AdService
{
    protected $storagePath;

    public function __construct()
    {
        // Sử dụng public_path để đảm bảo linh hoạt
        $this->storagePath = public_path('upload/ad');
    }

    public function createAd($data)
    {
        if (isset($data['image'])) {
            // Đảm bảo thư mục tồn tại
            if (!is_dir($this->storagePath)) {
                mkdir($this->storagePath, 0755, true);
            }

            // Lưu ảnh vào thư mục chỉ định
            $data['image']->move($this->storagePath, $data['image']->getClientOriginalName());
            $data['image'] = $data['image']->getClientOriginalName();
        }

        return Ad::create($data);
    }

    public function updateAd(Ad $ad, $data)
    {
        if (isset($data['image'])) {
            // Xóa ảnh cũ nếu có
            if ($ad->image && file_exists($this->storagePath . '/' . $ad->image)) {
                unlink($this->storagePath . '/' . $ad->image);
            }

            // Lưu ảnh mới
            $data['image']->move($this->storagePath, $data['image']->getClientOriginalName());
            $data['image'] = $data['image']->getClientOriginalName();
        }

        $ad->update($data);
        return $ad;
    }

    public function deleteAd(Ad $ad)
    {
        // Xóa ảnh từ thư mục
        if ($ad->image && file_exists($this->storagePath . '/' . $ad->image)) {
            unlink($this->storagePath . '/' . $ad->image);
        }

        return $ad->delete();
    }
}
