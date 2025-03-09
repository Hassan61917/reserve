<?php

namespace App\Handlers\Booking\Rules;

use App\Exceptions\ModelException;
use App\Handlers\IModelHandler;
use App\Models\Booking;
use App\ModelServices\Booking\BookingService;
use Illuminate\Database\Eloquent\Model;

class CheckBooked implements IModelHandler
{
    public function __construct(
        public BookingService $bookingService
    )
    {
    }

    public function handle(Model|Booking $model, array $params = []): void
    {
        if (!$this->bookingService->canBook($params)) {
            throw new ModelException("item is already booked");
        }
    }
}
