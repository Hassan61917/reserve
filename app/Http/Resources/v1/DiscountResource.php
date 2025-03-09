<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use App\Models\ServiceItem;
use Illuminate\Http\Request;

class DiscountResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "code" => $this->code,
            "amount" => $this->amount,
            "percent" => $this->percent,
            "limit" => $this->limit,
            "maxAmount" => $this->max_amount,
            "totalBalance" => $this->total_balance,
            "expireAt" => $this->expire_at->diffForHumans(),
            "category" => $this->mergeRelation(CategoryResource::class, "category"),
            "service" => $this->mergeRelation(ServiceResource::class, "service"),
            "item" => $this->mergeRelation(ServiceItem::class, "item"),
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "client" => $this->mergeRelation(UserResource::class, "client"),
            "users" => $this->mergeRelations(UserResource::class, "users")
        ];
    }
}
