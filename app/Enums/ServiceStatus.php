<?php

namespace App\Enums;

enum ServiceStatus: string
{
    case Draft = "Draft";
    case Complete = "Complete";
    case Suspend = "Suspend";
}
