<?php

use App\Http\Controllers\Api\v1\User\UserDiscountController;
use App\Http\Controllers\Api\v1\User\UserServiceController;
use App\Http\Controllers\Api\v1\User\UserServiceDayOffController;
use App\Http\Controllers\Api\v1\User\UserServiceItemController;
use App\Http\Controllers\Api\v1\User\UserServiceProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource("services", UserServiceController::class);
Route::prefix("/services/{service}")->name("services.")->group(function () {
    Route::get("/profile", [UserServiceProfileController::class, "index"])->name("profile.index");
    Route::put("/profile", [UserServiceProfileController::class, "update"])->name("profile.update");
    Route::apiResource("/items", UserServiceItemController::class);
    Route::apiResource("/day-offs", UserServiceDayOffController::class);
});

Route::apiResource("discounts", UserDiscountController::class);
