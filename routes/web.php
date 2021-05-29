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

Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');
Route::get('/done', [App\Http\Controllers\TaskController::class, 'index'])->name('done');

Route::get('/main_tasks', [App\Http\Controllers\TaskController::class, 'getMainTasks'])->name('main_tasks');
Route::get('/done_tasks', [App\Http\Controllers\TaskController::class, 'getDoneTasks'])->name('done_tasks');


Route::post('addTask', [App\Http\Controllers\TaskController::class, 'addtask']);

Route::post('toDone', [App\Http\Controllers\TaskController::class, 'taskToDone']);

Route::post('deleteTask', [App\Http\Controllers\TaskController::class, 'deleteTask']);
