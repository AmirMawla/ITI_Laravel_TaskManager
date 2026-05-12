<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'completed' => $this->completed,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'assigned' => new UserResource($this->whenLoaded('assigned')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
