<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use App\Models\ServiceItem;
use Illuminate\Http\Request;

class QuestionResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "question" => $this->question,
            "answer" => $this->answer,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "service" => $this->mergeRelation(ServiceResource::class, "service"),
            "item" => $this->mergeRelation(ServiceItem::class, "item"),
        ];
    }
}
