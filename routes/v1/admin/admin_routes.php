<?php

use App\Http\Controllers\Api\v1\Admin\AdminBanController;
use App\Http\Controllers\Api\v1\Admin\AdminRoleController;
use App\Http\Controllers\Api\v1\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::apiResource("roles", AdminRoleController::class);

Route::apiResource("users", AdminUserController::class);
Route::post("/users/{user}/{role}/add-role", [AdminUserController::class, 'addRole'])->name('users.add-role');
Route::delete("/users/{user}/{role}/remove-role", [AdminUserController::class, 'removeRole'])->name('users.remove-role');

Route::apiResource("bans", AdminBanController::class);
Route::post("/bans/{user}/ban", [AdminBanController::class, "ban"])->name("user.ban");
Route::post("/bans/{user}/unban", [AdminBanController::class, "unban"])->name("user.unban");
