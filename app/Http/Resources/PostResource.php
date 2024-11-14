<?php

namespace App\Http\Resources;

use App\Helpers\IdEncoder_2;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'encoded_id' => $this->encoded_id ?? IdEncoder_2::encode($this->id),
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'seo' => [
                'title' => $this->seo_title,
                'description' => $this->seo_description,
                'keywords' => $this->seo_keywords,
            ],
            'status' => [
                'is_featured' => (bool) $this->is_featured,
                'is_published' => (bool) $this->is_published,
            ],
            'comments_count' => $this->whenCounted('comments'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'meta' => [
                'can_edit' => $request->user()?->can('update', $this->resource),
                'can_delete' => $request->user()?->can('delete', $this->resource),
            ],
        ];
    }
}
