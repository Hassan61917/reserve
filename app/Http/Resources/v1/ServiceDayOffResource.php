<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class ServiceDayOffResource extends AppJsonResource
{
    private array $week = [
        1 => "Saturday",
        2 => "Sunday",
        3 => "Monday",
        4 => "Thursday",
        5 => "Wednesday",
        6 => "Thursday",
        7 => "Friday",
    ];

    public function toArray(Request $request): array
    {
        return [
            "inWeek" => $this->week[$this->in_week],
            "inMonth" => $this->in_month,
            "date" => $this->date ? $this->date->format('d-m-Y') : $this->date,
            "service" => $this->mergeRelation(ServiceResource::class, "service"),
            "item" => $this->mergeRelation(ServiceItemResource::class, "item"),
        ];
    }
}
