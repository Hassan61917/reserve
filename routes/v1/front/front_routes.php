<?php

use App\Http\Controllers\Api\v1\Front\FrontAdsController;
use App\Http\Controllers\Api\v1\Front\FrontCategoryController;
use App\Http\Controllers\Api\v1\Front\FrontPageController;
use App\Http\Controllers\Api\v1\Front\FrontServiceController;
use App\Http\Controllers\Api\v1\Front\FrontServiceItemController;
use App\Http\Controllers\FrontPostController;
use Illuminate\Support\Facades\Route;

Route::get("advertises", [FrontAdsController::class, "index"])->name("ads.index");

Route::get("categories", [FrontCategoryController::class, "index"])->name("categories.index");
Route::get("categories/{category}", [FrontCategoryController::class, "show"])->name("categories.show");

Route::get("services", [FrontServiceController::class, "index"])->name("services.index");
Route::get("/services/{service}",[FrontServiceController::class, "show"])->name("services.show");

Route::get("/service-items", [FrontServiceItemController::class, "index"])->name("service-items.index");
Route::get("/service-items/{service_item}",[FrontServiceItemController::class, "show"])->name("service-items.show");


Route::middleware(["auth:sanctum"])->group(function () {
    Route::prefix("social")->name("social.")->group(function () {
        Route::get("/", [FrontPageController::class, "index"])->name("pages.index");
        Route::get("page-posts", [FrontPageController::class, "pagePosts"])->name("pages.posts");
        Route::get("/{page}", [FrontPageController::class, "show"])->name("pages.show");
        Route::post("/{page}/follow", [FrontPageController::class, "follow"])->name("pages.follow");
        Route::post("/{page}/unfollow", [FrontPageController::class, "unFollow"])->name("pages.unfollow");
        Route::get("posts", [FrontPostController::class, "posts"])->name("posts.index");
        Route::get("/posts/{post}", [FrontPostController::class, "show"])->name("posts.show");
    });
});
