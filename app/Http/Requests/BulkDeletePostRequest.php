<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeletePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Nếu bạn muốn kiểm tra quyền người dùng, hãy thực hiện kiểm tra ở đây.
    }

    public function rules()
    {
        return [
            'post_ids' => 'required|array',
            'post_ids.*' => 'required|exists:posts,id'
        ];
    }

    public function messages()
    {
        return [
            'post_ids.required' => 'Vui lòng chọn ít nhất một bài viết để xóa.',
            'post_ids.array' => 'Định dạng dữ liệu không hợp lệ.',
            'post_ids.*.exists' => 'Một số bài viết không tồn tại.',
        ];
    }
}
