<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SlugController extends Controller
{

    public function checkSlug(Request $request)
    {
        // Log để debug
        Log::info('Checking slug:', $request->all());

        try {
            $slug = $request->slug;
            $postId = $request->post_id;

            // Kiểm tra slug có tồn tại không và không phải là post hiện tại
            $exists = Post::where('slug', $slug)
                ->when($postId, function ($query) use ($postId) {
                    return $query->where('id', '!=', $postId);
                })
                ->exists();

            // Log kết quả
            Log::info('Slug check result:', ['exists' => $exists]);

            return response()->json([
                'duplicate' => $exists,
                'message' => $exists ? 'Slug đã tồn tại' : 'Slug có thể sử dụng'
            ]);
        } catch (\Exception $e) {
            // Log lỗi nếu có
            Log::error('Slug check error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Có lỗi xảy ra khi kiểm tra slug'
            ], 500);
        }
    }
}
