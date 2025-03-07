<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")
    ->name("v1.")
    ->group(function () {
        require_once __DIR__ . "/v1/v1_routes.php";
    });


