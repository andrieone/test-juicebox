<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="PostResource",
 *   type="object",
 *   title="PostResource",
 *   @OA\Property(property="id", type="integer", description="ID of the post"),
 *   @OA\Property(property="title", type="string", description="Title of the post"),
 *   @OA\Property(property="content", type="string", description="Content of the post"),
 *   @OA\Property(property="user_id", type="integer", description="ID of the user who created the post"),
 *   @OA\Property(property="created_at", type="string", description="Date and time the post was created"),
 *   @OA\Property(property="updated_at", type="string", description="Date and time the post was updated"),
 * )
 */
class PostResource extends JsonResource
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
            'content' => $this->content,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
