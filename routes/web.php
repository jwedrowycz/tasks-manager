<?php

use App\Http\Controllers\UserController;
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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'user', 'middleware'=>'auth', 'as'=>'user.'], function () {
    Route::get('/uzytkownik', [UserController::class, 'index'])->name('user');
//    Route::get('/delete/{opinion_id}', [UserController::class, 'destroy'])->name('destroy');
});
