<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class StateResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "citiesCount" => $this->mergeCount("cities"),
            "cities" => $this->mergeRelations(CityResource::class, "cities"),
        ];
    }
}
