<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Draft = "Draft";
    case Paid = "Paid";
    case Confirmed = "Confirmed";
    case Cancelled = "Cancelled";
    case Completed = "Completed";
}
