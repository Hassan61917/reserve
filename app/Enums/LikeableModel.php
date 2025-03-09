<?php

namespace App\Enums;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Question;
use App\Models\Review;
use App\Models\ServiceItem;

enum LikeableModel: string
{
    case item = ServiceItem::class;
    case review = Review::class;
    case question = Question::class;
    case post = Post::class;
    case comment = Comment::class;
}
