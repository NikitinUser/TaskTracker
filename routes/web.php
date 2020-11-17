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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('home/addtask', [App\Http\Controllers\HomeController::class, 'addtask']);

Route::post('home/totrash', [App\Http\Controllers\HomeController::class, 'totrash']);


Route::get('/trash', [App\Http\Controllers\HomeController::class, 'trash'])->name('trash');

//Route::post('trash/deleteTask', [App\Http\Controllers\HomeController::class, 'deleteTask']);

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'settings'])->name('settings');
/*
Route::get('/settings/aboutsend', [App\Http\Controllers\SettingsController::class, 'aboutsend'])->name('aboutsend');
Route::post('settings/send', [App\Http\Controllers\SettingsController::class, 'send']);
Route::post('settings/save', [App\Http\Controllers\SettingsController::class, 'save']);
Route::post('settings/deleteUser', [App\Http\Controllers\SettingsController::class, 'deleteUser']);
*/