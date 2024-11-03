<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'meta' => [
                'can_edit' => $request->user()?->can('update', $this->resource),
                'can_delete' => $request->user()?->can('delete', $this->resource),
            ],
        ];
    }
}
