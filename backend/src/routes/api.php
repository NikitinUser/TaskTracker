<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/check_token', [AuthController::class, 'checkToken']);
    Route::post('/remove', [AuthController::class, 'remove']);
});

Route::prefix('task')->group(function () {
    Route::get('/user/all', [TaskController::class, 'getUserTasks']);
    Route::post('/', [TaskController::class, 'addtask']);
    Route::patch('/', [TaskController::class, 'updateTask']);
    Route::delete('/', [TaskController::class, 'deleteTask']);
});
