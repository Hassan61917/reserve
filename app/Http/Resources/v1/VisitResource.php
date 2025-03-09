<?php

namespace App\Http\Resources\v1;

use App\Enums\VisitableModel;
use App\Http\Resources\AppJsonResource;
use App\Models\ServiceItem;
use Illuminate\Http\Request;

class VisitResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "ip" => $this->ip,
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "subject" => $this->mergeRelation($this->getSubjectResource(),"visitable")
        ];
    }

    private function getSubjectResource(): string
    {
        return match ($this->visitable_type) {
            VisitableModel::post->value => PostResource::class,
            VisitableModel::item->value => ServiceItem::class
        };
    }
}
