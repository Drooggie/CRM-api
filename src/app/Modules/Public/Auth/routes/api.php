<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Public\Auth\Controllers\AuthController;

Route::group(['prefix' => 'api/v1/public/auth'], function () {

    Route::get('/', [AuthController::class, 'index']);
});
