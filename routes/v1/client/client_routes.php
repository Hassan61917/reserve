<?php

use App\Http\Controllers\Api\v1\Client\ClientBookingController;
use App\Http\Controllers\Api\v1\Client\ClientDiscountController;
use App\Http\Controllers\Api\v1\Client\ClientQuestionController;
use App\Http\Controllers\Api\v1\Client\ClientReviewController;
use App\Http\Controllers\Api\v1\Client\ClientWishlistController;
use Illuminate\Support\Facades\Route;

Route::get("used-discounts", [ClientDiscountController::class, "used"])->name("discounts.used");
Route::get("discounts", [ClientDiscountController::class, "index"])->name("discounts.index");
Route::get("discounts/{discount}", [ClientDiscountController::class, "show"])->name("discounts.show");

Route::apiResource("bookings", ClientBookingController::class);
Route::post("/bookings/{booking}/cancel", [ClientBookingController::class, 'cancel'])->name('booking.cancel');

Route::apiResource("reviews", ClientReviewController::class);

Route::apiResource("questions", ClientQuestionController::class);

Route::apiResource("wishlist", ClientWishlistController::class)->except("update");
