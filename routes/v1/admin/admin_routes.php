<?php

use App\Http\Controllers\Api\v1\Admin\AdminBanController;
use App\Http\Controllers\Api\v1\Admin\AdminBookingController;
use App\Http\Controllers\Api\v1\Admin\AdminCategoryController;
use App\Http\Controllers\Api\v1\Admin\AdminCityController;
use App\Http\Controllers\Api\v1\Admin\AdminCommentController;
use App\Http\Controllers\Api\v1\Admin\AdminDiscountController;
use App\Http\Controllers\Api\v1\Admin\AdminMessageController;
use App\Http\Controllers\Api\v1\Admin\AdminOrderController;
use App\Http\Controllers\Api\v1\Admin\AdminPostController;
use App\Http\Controllers\Api\v1\Admin\AdminQuestionController;
use App\Http\Controllers\Api\v1\Admin\AdminReviewController;
use App\Http\Controllers\Api\v1\Admin\AdminRoleController;
use App\Http\Controllers\Api\v1\Admin\AdminServiceController;
use App\Http\Controllers\Api\v1\Admin\AdminServiceItemController;
use App\Http\Controllers\Api\v1\Admin\AdminStateController;
use App\Http\Controllers\Api\v1\Admin\AdminUserController;
use App\Http\Controllers\Api\v1\Admin\AdminWalletController;
use App\Http\Controllers\Api\v1\Admin\AdminWalletTransactionController;
use Illuminate\Support\Facades\Route;

Route::apiResource("roles", AdminRoleController::class);

Route::apiResource("users", AdminUserController::class);
Route::post("/users/{user}/{role}/add-role", [AdminUserController::class, 'addRole'])->name('users.add-role');
Route::delete("/users/{user}/{role}/remove-role", [AdminUserController::class, 'removeRole'])->name('users.remove-role');

Route::apiResource("bans", AdminBanController::class);
Route::post("/bans/{user}/ban", [AdminBanController::class, "ban"])->name("user.ban");
Route::post("/bans/{user}/unban", [AdminBanController::class, "unban"])->name("user.unban");

Route::apiResource("states", AdminStateController::class);
Route::apiResource("cities", AdminCityController::class);

Route::apiResource("wallets", AdminWalletController::class)->except(["update", "destroy"]);
Route::prefix("wallets/{wallet}")->name("wallets.")->group(function () {
    Route::post("/block", [AdminWalletController::class, "block"])->name("block");
    Route::post("/unblock", [AdminWalletController::class, "unblock"])->name("unblock");
    Route::post("/deposit", [AdminWalletController::class, "deposit"])->name("deposit");
    Route::post("/withdraw", [AdminWalletController::class, "withdraw"])->name("withdraw");
    Route::post("/{destination}/transfer", [AdminWalletController::class, "transfer"])->name("transfer");
});
Route::apiResource("wallet-transactions", AdminWalletTransactionController::class)->except(["store", "update"]);

Route::apiResource("categories", AdminCategoryController::class);

Route::apiResource("services", AdminServiceController::class)->except("store");
Route::prefix("/services/{service}")->name("service.")->group(function () {
    Route::post("suspend", [AdminServiceController::class, 'suspend'])->name('suspend');
    Route::put("/update-profile", [AdminServiceController::class, 'updateProfile'])->name('update-profile');
});
Route::apiResource("service-items", AdminServiceItemController::class)->except("store");

Route::apiResource("discounts", AdminDiscountController::class);

Route::apiResource("orders", AdminOrderController::class)->except("store", "update");

Route::apiResource("bookings", AdminBookingController::class)->except("store");

Route::apiResource("reviews", AdminReviewController::class)->except("store");

Route::apiResource("questions", AdminQuestionController::class)->except("store");

Route::apiResource("messages", AdminMessageController::class)->except("store");

Route::apiResource("posts", AdminPostController::class);

Route::apiResource("comments", AdminCommentController::class);
