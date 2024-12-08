<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Guest\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1/guest'], function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::get('/create', [UserController::class, 'create']);
        Route::path('/{user}', [UserController::class, 'update'])->can('update', 'user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->can('edit', 'user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->can('destroy', 'user');
    });
});
