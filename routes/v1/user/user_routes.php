<?php

use App\Http\Controllers\Api\v1\User\UserProfileController;
use App\Http\Controllers\Api\v1\User\UserWalletController;
use App\Http\Controllers\Api\v1\User\UserWalletTransactionController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/profile", UserProfileController::class)->except(["show", "delete"]);

Route::prefix("wallet")->name("wallet.")->group(function () {
    Route::get("/", [UserWalletController::class, "index"])->name("index");
    Route::post("update-password", [UserWalletController::class, "setPassword"])->name("update-password");
//    Route::post("/deposit", [UserWalletController::class, "deposit"])->name("deposit");
//    Route::post("/withdraw", [UserWalletController::class, "withdraw"])->name("withdraw");
});
Route::apiResource("wallet-transactions", UserWalletTransactionController::class)->except("store", "destroy");
