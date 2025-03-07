<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class RoleResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "slug" => $this->slug,
            "title" => $this->title,
            "users_count" => $this->mergeCount("users"),
            "users" => $this->mergeRelations(UserResource::class, "users"),
        ];
    }
}
