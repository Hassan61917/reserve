<?php

use App\Http\Controllers\Api\v1\Client\ClientDiscountController;
use Illuminate\Support\Facades\Route;

Route::get("used-discounts", [ClientDiscountController::class, "used"])->name("discounts.used");
Route::get("discounts", [ClientDiscountController::class, "index"])->name("discounts.index");
Route::get("discounts/{discount}", [ClientDiscountController::class, "show"])->name("discounts.show");
