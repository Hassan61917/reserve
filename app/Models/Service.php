<?php

namespace App\Models;


use App\Enums\ServiceStatus;
use App\Models\Trait\Relations\ServiceRelations;
use App\Models\Trait\With\WithDayOffs;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Service extends AppModel
{
    use ServiceRelations,
        WithDayOffs;

    protected $with = ['category'];

    public function scopeAvailable(Builder $builder, Carbon $carbon, ?User $user = null): Builder
    {
       // $date = $carbon->format('Y-m-d');
        $hour = $carbon->hour;
        $stateId = $user?->profile->state->id;
        $cityId = $user?->profile->city->id;
        return $builder->whereHas("profile", function ($query) use ($hour, $stateId, $cityId) {
            $result = $query->isOpen($hour);
            if ($stateId && $cityId) {
                $result = $result->inCity($stateId, $cityId);
            }
            return $result;
        })->completed();
    }
    public function scopeCompleted(Builder $builder): Builder
    {
        return $builder->where("status", ServiceStatus::Complete->value);
    }

    protected $fillable = [
        "category_id", "name", "slug", "description", "status"
    ];

    public function isCompleted(): bool
    {
        return $this->status == ServiceStatus::Complete->value;
    }
}
