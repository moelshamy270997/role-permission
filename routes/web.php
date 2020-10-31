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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('user', 'App\Http\Controllers\UserController');
Route::post('user/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('user.restore');

Route::resource('role', 'App\Http\Controllers\RoleController');
Route::post('role/restore', [App\Http\Controllers\RoleController::class, 'restore'])->name('role.restore');

Route::resource('permission', 'App\Http\Controllers\PermissionController');
Route::post('permission/restore', [App\Http\Controllers\PermissionController::class, 'restore'])->name('permission.restore');
