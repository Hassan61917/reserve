<?php

namespace App\Models\Trait\With;

use App\Exceptions\ModelException;
use App\Models\ServiceDayoff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait WithDayOffs
{
    public function scopeOpen(Builder $builder, string $date)
    {
        $data = $this->toDayOffData($date);
        return $builder
            ->join('service_dayoffs', 'service_dayoffs.id', '=', 'service_dayoffs.service_id')
            ->whereNot("in_week", $data["in_week"])
            ->WhereNot("in_month", $data["in_month"])
            ->WhereNot("date", $data["date"]);
    }
    public function isClosed(string $date): bool
    {
        $data = $this->toDayOffData($date);
        return $this->hasDayOff($data);
    }

    public function addDayOff(array $data): ServiceDayoff
    {
        if ($this->hasDayOff($data)) {
            throw new ModelException("you have already submitted this day off");
        }
        return $this->dayOffs()->create($data);
    }

    public function hasDayOff(array $data): bool
    {
        $query = $this->dayOffs();
        return $query
            ->where("in_week", $data["in_week"])
            ->orWhere("in_month", $data["in_month"])
            ->orWhere("date", $data["date"])
            ->exists();
    }

    protected function toDayOffData(string $date): array
    {
        $carbon = Carbon::make($date);
        $weekDay = $carbon->dayOfWeek + 2;
        $weekDay = $weekDay > 7 ? $weekDay - 7 : ($weekDay == 0 ? 1 : $weekDay);
        $monthDay = $carbon->dayOfMonth;
        return [
            "in_week" => $weekDay,
            "in_month" => $monthDay,
            "date" => $date,
        ];
    }


}
