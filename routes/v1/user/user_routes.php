<?php

use App\Http\Controllers\Api\v1\User\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/profile", UserProfileController::class)->except(["show", "delete"]);
