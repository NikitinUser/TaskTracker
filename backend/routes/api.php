<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('registrate', [App\Http\Controllers\AuthController::class, 'registrate']);
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'task'
], function () {
    Route::get('', [App\Http\Controllers\TaskController::class, 'getAll']);
    Route::post('', [App\Http\Controllers\TaskController::class, 'create']);
    Route::post('/update', [App\Http\Controllers\TaskController::class, 'update']);
    Route::delete('/{taskId}', [App\Http\Controllers\TaskController::class, 'delete']);
});
