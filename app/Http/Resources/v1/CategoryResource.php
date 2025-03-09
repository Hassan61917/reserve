<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class CategoryResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "icon" => $this->icon,
            "children_count" => $this->mergeCount("children"),
            "children" => $this->mergeRelations(CategoryResource::class, "children",["children"]),
            "services" => $this->mergeRelations(ServiceResource::class, "services"),
        ];
    }
}
