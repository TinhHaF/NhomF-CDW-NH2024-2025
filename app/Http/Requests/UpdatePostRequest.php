<?php

namespace App\Http\Requests;

use App\Helpers\IdEncoder_2;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UpdatePostRequest extends FormRequest
{
    /**
     * @var int|null
     */
    private $decodedId = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        try {
            $encodedId = $this->route('encodedId');

            if (!$encodedId) {
                logger()->error('Missing route parameter', [
                    'route' => $this->route()->getName(),
                    'parameters' => $this->route()->parameters()
                ]);
                throw new InvalidArgumentException('Post ID is required');
            }

            logger()->info('Decoding post ID', ['encoded_id' => $encodedId]);

            $this->decodedId = IdEncoder_2::decode($encodedId);

            if (!$this->decodedId) {
                throw new InvalidArgumentException('Invalid encoded ID format');
            }

            logger()->info('ID decoded successfully', [
                'encoded_id' => $encodedId,
                'decoded_id' => $this->decodedId
            ]);

            // Generate slug from title if not provided
            if ($this->has('title') && !$this->has('slug')) {
                $this->merge([
                    'slug' => Str::slug($this->title),
                ]);
            }
        } catch (\Exception $e) {
            logger()->error('Failed to process request', [
                'error' => $e->getMessage(),
                'encoded_id' => $encodedId ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore($this->decodedId),
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('posts')->ignore($this->decodedId),
            ],
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string',
            'seo_keywords' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'title.unique' => 'Tiêu đề đã tồn tại.',

            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi.',
            'slug.unique' => 'Slug đã tồn tại.',

            'content.required' => 'Nội dung là bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi.',

            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',

            'author_id.required' => 'Tác giả là bắt buộc.',
            'author_id.exists' => 'Tác giả không hợp lệ.',

            'seo_title.required' => 'Tiêu đề SEO là bắt buộc.',
            'seo_title.string' => 'Tiêu đề SEO phải là chuỗi.',
            'seo_title.max' => 'Tiêu đề SEO không được vượt quá 255 ký tự.',

            'seo_description.required' => 'Mô tả SEO là bắt buộc.',
            'seo_description.string' => 'Mô tả SEO phải là chuỗi.',

            'seo_keywords.required' => 'Từ khóa SEO là bắt buộc.',
            'seo_keywords.string' => 'Từ khóa SEO phải là chuỗi.',
            'seo_keywords.max' => 'Từ khóa SEO không được vượt quá 255 ký tự.',

            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
        ];
    }

    /**
     * Get the decoded ID.
     */
    public function getDecodedId(): ?int
    {
        return $this->decodedId;
    }
}
