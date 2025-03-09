<?php

namespace App\Enums;

use App\Models\Post;
use App\Models\ServiceItem;

enum VisitableModel: string
{
    case item = ServiceItem::class;
    case post = Post::class;
}
