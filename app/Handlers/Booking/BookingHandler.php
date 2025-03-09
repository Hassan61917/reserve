<?php

namespace App\Handlers\Booking;

use App\Exceptions\ModelException;
use App\Handlers\Booking\Rules\CheckBooked;
use App\Handlers\Booking\Rules\CheckDayOff;
use App\Handlers\ModelHandler;
use App\Models\Booking;
use App\Models\ServiceItem;

class BookingHandler extends ModelHandler
{
    protected array $rules = [
        "checkStatus",
        "checkOwner",
        "checkHour",
        CheckDayOff::class,
        CheckBooked::class
    ];


    public function checkStatus(ServiceItem $item): void
    {
        if (!$item->service->isCompleted()) {
            throw new ModelException("this service is not bookable");
        }
    }

    public function checkOwner(ServiceItem $item): void
    {
        if (auth()->user()->is($booking->service->user)) {
            throw new ModelException("you can't book your own service");
        }
    }

    public function checkHour(ServiceItem $item, array $data): void
    {
        $profile = $item->service->profile;
        $start = $profile->open_at;
        $end = $profile->close_at;
        $hour = $data["hour"];
        if ($hour < $start || $end < $hour) {
            throw new ModelException("you can't book in this hour");
        }
    }
}
