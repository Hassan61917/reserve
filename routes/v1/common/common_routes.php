<?php

use App\Http\Controllers\Api\v1\Common\CommonOrderController;
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

Route::apiResource("orders", CommonOrderController::class)->except("store");
Route::post("/orders/{order}/discount", [CommonOrderController::class, 'discount'])->name('order.discount');
Route::post("/orders/{order}/pay", [CommonOrderController::class, 'pay'])->name('order.pay');
Route::post("/orders/{order}/cancel", [CommonOrderController::class, 'cancel'])->name('order.cancel');

