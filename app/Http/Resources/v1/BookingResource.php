<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class BookingResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "date" => $this->date,
            "hour" => $this->hour,
            "status" => $this->status,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "service" => $this->mergeRelation(ServiceResource::class, "service"),
            "item" =>$this->mergeRelation(ServiceItemResource::class,"item"),
        ];
    }
}
