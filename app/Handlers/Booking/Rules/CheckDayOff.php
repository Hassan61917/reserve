<?php

namespace App\Handlers\Booking\Rules;

use App\Exceptions\ModelException;
use App\Handlers\IModelHandler;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class CheckDayOff implements IModelHandler
{
    public function handle(Model|Booking $model, array $params = []): void
    {
        $date = $params["date"];
        if ($model->service->isClosed($date) || $model->item->isClosed($date)) {
            throw new ModelException("you can't book service in day off days");
        }
    }
}
