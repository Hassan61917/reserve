<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use App\Models\ServiceItem;
use Illuminate\Http\Request;

class LadderOrderResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "status" => $this->status,
            "showedAt" => $this->show_at->DiffForHumans(),
            "endAt" => $this->end_at ? $this->end_at->DiffForHumans() : null,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "item" => $this->mergeRelation(ServiceItem::class, "item"),
            "ladder" => $this->mergeRelation(LadderResource::class, "ladder")
        ];
    }
}
