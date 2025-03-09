<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class ServiceItemResource extends AppJsonResource
{
    protected array $resources = [
        VisitCountResource::class,
        LikeCountResource::class
    ];
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "duration" => $this->duration,
            "price" => $this->price,
            "available" => $this->available,
            "hidden" => $this->hidden,
            "service" => $this->mergeRelation(ServiceResource::class, "service"),
            "dayOffs" => $this->mergeRelations(ServiceDayOffResource::class, "dayOffs"),
            "bookings" => $this->mergeRelations(BookingResource::class, "bookings"),
            "reviews" => $this->mergeRelations(ReviewResource::class, "reviews"),
            "bookingsCount" => $this->mergeCount("bookings"),
            "dayOffsCount" => $this->mergeCount("dayOffs"),
        ];
    }
}
