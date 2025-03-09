<?php

use App\Http\Controllers\Api\v1\Common\CommonProfileController;
use App\Http\Controllers\Api\v1\Common\CommonWalletController;
use App\Http\Controllers\Api\v1\Common\CommonWalletTransactionController;
use Illuminate\Support\Facades\Route;


Route::apiResource("/profile", CommonProfileController::class)->except(["show", "delete"]);


Route::prefix("wallet")->name("wallet.")->group(function () {
    Route::get("/", [CommonWalletController::class, "index"])->name("index");
    Route::post("setPassword", [CommonWalletController::class, "setPassword"])->name("setPassword");
    Route::post("/deposit", [CommonWalletController::class, "deposit"])->name("deposit");
    Route::post("/withdraw", [CommonWalletController::class, "withdraw"])->name("withdraw");
});
Route::apiResource("wallet-transactions", CommonWalletTransactionController::class)->except("store", "destroy");
