<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Post;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $postId = $this->route('post'); // Lấy ID từ route nếu đang update

        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($postId),
                'regex:/^[a-z0-9-]+$/'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung không được để trống',
            'slug.required' => 'Đường dẫn không được để trống',
            'slug.unique' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
            'slug.regex' => 'Đường dẫn chỉ được chứa chữ thường, số và dấu gạch ngang',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Nếu không có slug được gửi lên, tạo slug từ title
        if (!$this->has('slug') || empty($this->slug)) {
            $this->merge([
                'slug' => str()->slug($this->title)
            ]);
        }
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->ajax()) {
            // Nếu là request ajax, trả về response json
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        parent::failedValidation($validator);
    }
}
