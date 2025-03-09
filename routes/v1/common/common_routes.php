<?php

use App\Http\Controllers\Api\v1\Common\CommonAdsOrderController;
use App\Http\Controllers\Api\v1\Common\CommonBlockController;
use App\Http\Controllers\Api\v1\Common\CommonCommentController;
use App\Http\Controllers\Api\v1\Common\CommonFollowController;
use App\Http\Controllers\Api\v1\Common\CommonLikeController;
use App\Http\Controllers\Api\v1\Common\CommonMessageController;
use App\Http\Controllers\Api\v1\Common\CommonOrderController;
use App\Http\Controllers\Api\v1\Common\CommonProfileController;
use App\Http\Controllers\Api\v1\Common\CommonReportController;
use App\Http\Controllers\Api\v1\Common\CommonTicketController;
use App\Http\Controllers\Api\v1\Common\CommonVisitController;
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

Route::apiResource("blocks", CommonBlockController::class);
Route::apiResource("messages", CommonMessageController::class)->except("index");
Route::get("inbox", [CommonMessageController::class, "inbox"])->name("inbox");
Route::get("outbox", [CommonMessageController::class, "outbox"])->name("outbox");
Route::get("chats", [CommonMessageController::class, "chats"])->name("chats");
Route::get("chats/{user}/chat", [CommonMessageController::class, "chat"])->name("chat");

Route::apiResource("comments", CommonCommentController::class);
Route::post("/comments/{comment}/reply", [CommonCommentController::class, "reply"])->name("comments.reply");


Route::get("follow-requests", [CommonFollowController::class, "index"])->name("follow.requests");
Route::post("/follow", [CommonFollowController::class, "follow"])->name("follow");
Route::post("/unfollow", [CommonFollowController::class, "unfollow"])->name("unfollow");

Route::apiResource("ads-orders", CommonAdsOrderController::class);
Route::post("ads-orders/{ads_order}/cancel", [CommonAdsOrderController::class, "cancel"])->name("ads-orders.cancel");

Route::apiResource("tickets", CommonTicketController::class);
Route::post("tickets/{ticket}/add-message", [CommonTicketController::class, "addMessage"])->name("tickets.addMessage");
Route::post("tickets/{ticket}/close", [CommonTicketController::class, "close"])->name("tickets.close");

Route::apiResource("reports", CommonReportController::class)->except("update");

Route::delete("visits/delete-all", [CommonVisitController::class, "destroyAll"])->name("visits.delete-all");
Route::apiResource("visits", CommonVisitController::class)->except("update");

Route::post("like", [CommonLikeController::class, "like"])->name("like");
Route::post("dislike", [CommonLikeController::class, "dislike"])->name("dislike");

