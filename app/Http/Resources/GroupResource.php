<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
        'name' => $this->name,
        'description' => $this->description ?? null,
        'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d') : null,
        'Users' => UserResource::collection($this->whenLoaded('users')),
        'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
      
    ];
}

}
