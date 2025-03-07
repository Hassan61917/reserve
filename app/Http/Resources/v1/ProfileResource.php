<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class ProfileResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "avatar" => $this->avatar,
            "phone" => $this->phone,
            "state" => $this->mergeRelation(StateResource::class, "state"),
            "city" => $this->mergeRelation(CityResource::class, "city"),
        ];
    }
}
