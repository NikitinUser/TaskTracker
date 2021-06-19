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
    return redirect("https://nikitinuser.github.io/ToDo/");	
})->name('demo');

Auth::routes();

Route::get('/statistic', [App\Http\Controllers\TaskStatisticController::class, 'index'])->name('statistic');
Route::get('/getCounTasks', [App\Http\Controllers\TaskStatisticController::class, 'getCounTasks'])->name('getCounTasks');

Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');
Route::get('/done', [App\Http\Controllers\TaskController::class, 'index'])->name('done');
Route::get('/archive', [App\Http\Controllers\TaskController::class, 'index'])->name('archive');
Route::get('/bookmarks', [App\Http\Controllers\TaskController::class, 'index'])->name('bookmarks');

Route::get('/get_tasks', [App\Http\Controllers\TaskController::class, 'getTasks'])->name('get_tasks');

Route::post('addTask', [App\Http\Controllers\TaskController::class, 'addtask']);

Route::post('changeTask', [App\Http\Controllers\TaskController::class, 'changeTask']);

Route::post('toActive', [App\Http\Controllers\TaskController::class, 'taskChangeType']);
Route::post('toDone', [App\Http\Controllers\TaskController::class, 'taskChangeType']);
Route::post('toArchive', [App\Http\Controllers\TaskController::class, 'taskChangeType']);
Route::post('toBookmark', [App\Http\Controllers\TaskController::class, 'taskChangeType']);

Route::post('deleteTask', [App\Http\Controllers\TaskController::class, 'deleteTask']);

Route::post('recoverTask', [App\Http\Controllers\TaskController::class, 'recoverTask']);
