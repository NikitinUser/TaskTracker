<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/demo', function () {
    return view("demo");	
})->name('demo');

Auth::routes();

Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');
Route::get('/done', [App\Http\Controllers\TaskController::class, 'index'])->name('done');
Route::get('/archive', [App\Http\Controllers\TaskController::class, 'index'])->name('archive');
Route::get('/bookmarks', [App\Http\Controllers\TaskController::class, 'index'])->name('bookmarks');

Route::get('tasks', [App\Http\Controllers\TaskController::class, 'getUserTasks'])->name('tasks');
Route::post('tasks', [App\Http\Controllers\TaskController::class, 'addtask']);
Route::put('tasks', [App\Http\Controllers\TaskController::class, 'rewriteTask']);
Route::delete('tasks', [App\Http\Controllers\TaskController::class, 'deleteTask']);
Route::post('tasks/recover', [App\Http\Controllers\TaskController::class, 'recoverTask']);
Route::post('taskSwapType', [App\Http\Controllers\TaskController::class, 'swapTheTypeOfTask']);
