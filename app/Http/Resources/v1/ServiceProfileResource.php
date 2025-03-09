<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class ServiceProfileResource extends AppJsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "open" => $this->open_at,
            "close" => $this->close_at,
            "phone" => $this->phone,
            "address" => $this->address,
            "state"=>$this->mergeRelation(StateResource::class,"state"),
            "city"=>$this->mergeRelation(CityResource::class,"city")
        ];
    }
}
