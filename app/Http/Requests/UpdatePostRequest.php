<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Nếu bạn muốn kiểm tra quyền người dùng, hãy thực hiện kiểm tra ở đây.
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore($this->post->id), // Đảm bảo $this->post->id tồn tại
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('posts')->ignore($this->post->id),
            ],
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string',
            'seo_keywords' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean', // Có thể là null
            'is_published' => 'nullable|boolean', // Có thể là null
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại.',
            'content.required' => 'Nội dung là bắt buộc.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'author_id.required' => 'Tác giả là bắt buộc.',
            'author_id.exists' => 'Tác giả không hợp lệ.',
            'seo_title.required' => 'Tiêu đề SEO là bắt buộc.',
            'seo_description.required' => 'Mô tả SEO là bắt buộc.',
            'seo_keywords.required' => 'Từ khóa SEO là bắt buộc.',
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('title') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }
    }
}
