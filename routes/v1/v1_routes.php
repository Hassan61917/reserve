<?php

use Illuminate\Support\Facades\Route;

Route::name("front.")
    ->group(function () {
        require_once __DIR__ . "/front/front_routes.php";
    });

Route::prefix("auth")
    ->name("auth.")
    ->group(function () {
        require_once __DIR__ . "/auth_routes.php";
    });

Route::prefix("user")
    ->name("user.")
    ->middleware(["auth:sanctum","role:user","notBan"])
    ->group(function () {
        require_once __DIR__ . "/user/user_routes.php";
    });

Route::prefix("admin")
    ->name("admin.")
    ->middleware(["auth:sanctum", "role:admin", "notBan"])
    ->group(function () {
        require_once __DIR__ . "/admin/admin_routes.php";
    });
