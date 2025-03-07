<?php

use App\Http\Controllers\Api\v1\Admin\AdminRoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource("roles", AdminRoleController::class);
