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

Route::get('/statistic', [App\Http\Controllers\TaskStatisticController::class, 'index'])->name('statistic');
Route::get('/getCountTasks', [App\Http\Controllers\TaskStatisticController::class, 'getCountTasks'])->name('getCountTasks');

Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');
Route::get('/done', [App\Http\Controllers\TaskController::class, 'index'])->name('done');
Route::get('/archive', [App\Http\Controllers\TaskController::class, 'index'])->name('archive');
Route::get('/bookmarks', [App\Http\Controllers\TaskController::class, 'index'])->name('bookmarks');

Route::get('/get_tasks', [App\Http\Controllers\TaskController::class, 'getUserTasks'])->name('get_tasks');

Route::post('addTask', [App\Http\Controllers\TaskController::class, 'addtask']);

Route::post('changeTask', [App\Http\Controllers\TaskController::class, 'rewriteTask']);

Route::post('taskSwapType', [App\Http\Controllers\TaskController::class, 'swapTheTypeOfTask']);

Route::post('deleteTask', [App\Http\Controllers\TaskController::class, 'deleteTask']);

Route::post('recoverTask', [App\Http\Controllers\TaskController::class, 'recoverTask']);

Route::get('/get_tasks_themes', [App\Http\Controllers\TaskController::class, 'getTasksThemes'])->name('get_tasks_themes');
