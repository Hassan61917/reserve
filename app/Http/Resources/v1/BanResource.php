<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BanResource extends AppJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "reason" => $this->reason,
            "finished" => $this->finished,
            "startedAt" => $this->started_at,
            "finishedAt" => Carbon::make($this->started_at)->addDays($this->duration),
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "admin" => $this->mergeRelation(UserResource::class, "admin"),
        ];
    }
}
