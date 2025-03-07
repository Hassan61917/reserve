<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\WithResponses;
use App\Models\User;

abstract class Controller
{
    use WithResponses;
    protected function authUser(array $relations = []): ?User
    {
        if (!auth()->check()) {
            return null;
        }
        return auth()->user()->load($relations);
    }
}
