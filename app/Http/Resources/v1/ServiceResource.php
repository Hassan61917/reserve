<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class ServiceResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "slug" => $this->slug,
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "category" => $this->mergeRelation(CategoryResource::class, "category"),
            "profile" => $this->mergeRelation(ServiceProfileResource::class, "profile"),
            "dayOffs" => $this->mergeRelations(ServiceDayOffResource::class, "dayOffs"),
            "items" => $this->mergeRelations(ServiceItemResource::class, "items"),
            "items_count" => $this->mergeCount("items"),
        ];
    }
}
