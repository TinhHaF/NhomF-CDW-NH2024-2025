<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Facades\Storage;

class AdService
{
    protected $storagePath = 'uploads/ads';

    public function createAd($data)
    {
        if (isset($data['image'])) {
            // Lưu ảnh vào thư mục `public/uploads/ads`
            $data['image'] = $data['image']->move(public_path($this->storagePath), $data['image']->getClientOriginalName());
            $data['image'] = $data['image']->getClientOriginalName();
        }

        return Ad::create($data);
    }

    public function updateAd(Ad $ad, $data)
    {
        if (isset($data['image'])) {
            // Xóa ảnh cũ nếu có
            if ($ad->image) {
                unlink(public_path($this->storagePath . '/' . $ad->image));
            }

            // Lưu ảnh mới vào thư mục `public/uploads/ads`
            $data['image'] = $data['image']->move(public_path($this->storagePath), $data['image']->getClientOriginalName());
            $data['image'] = $data['image']->getClientOriginalName();
        }

        $ad->update($data);
        return $ad;
    }

    public function deleteAd(Ad $ad)
    {
        // Xóa ảnh từ thư mục `public/uploads/ads`
        if ($ad->image) {
            unlink(public_path($this->storagePath . '/' . $ad->image));
        }

        return $ad->delete();
    }
}
