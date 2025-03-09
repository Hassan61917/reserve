<?php

use App\Http\Controllers\Api\v1\User\UserBookingController;
use App\Http\Controllers\Api\v1\User\UserCommentController;
use App\Http\Controllers\Api\v1\User\UserDiscountController;
use App\Http\Controllers\Api\v1\User\UserPageController;
use App\Http\Controllers\Api\v1\User\UserPostController;
use App\Http\Controllers\Api\v1\User\UserQuestionController;
use App\Http\Controllers\Api\v1\User\UserReviewController;
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

Route::get("/bookings", [UserBookingController::class, 'index'])->name('bookings.index');
Route::prefix("bookings/{booking}")->name("bookings.")->group(function () {
    Route::get("/", [UserBookingController::class, 'show'])->name('show');
    Route::post("confirm", [UserBookingController::class, 'confirm'])->name('confirm');
    Route::post("cancel", [UserBookingController::class, 'cancel'])->name('cancel');
});

Route::get("/reviews", [UserReviewController::class, 'index'])->name('reviews.index');
Route::get("/reviews/{review}", [UserReviewController::class, 'show'])->name('reviews.show');
Route::get("/reviews/{review}/reply", [UserReviewController::class, 'reply'])->name('reviews.reply');

Route::get("/questions", [UserQuestionController::class, "index"])->name("questions.index");
Route::get("/questions/{question}", [UserQuestionController::class, "show"])->name("questions.show");
Route::post("/questions/{question}/answer", [UserQuestionController::class, "answer"])->name("questions.answer");

Route::apiResource("page", UserPageController::class)->only("index", "update");

Route::apiResource("posts", UserPostController::class);

Route::get("/comments", [UserCommentController::class, "index"])->name("comments.index");
Route::get("/comments/{comment}", [UserCommentController::class, "show"])->name("comments.show");
