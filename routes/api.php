<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Task */
Route::get('tasks', [TaskController::class, 'index']);
Route::get('tasks/{task}', [TaskController::class, 'show']);
Route::post('tasks', [TaskController::class, 'store'])->middleware('auth:sanctum');
Route::put('tasks/{task}', [TaskController::class, 'update'])->middleware('auth:sanctum');
Route::put('tasks/complete/{task}', [TaskController::class, 'complete'])->middleware('auth:sanctum');
Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->middleware('auth:sanctum');
// Route::resource('tasks', TaskController::class);

// Route::post('register', 'App\\Http\\Controllers\\Api\\AuthController@register');
// Route::post('login', 'App\\Http\\Controllers\\Api\\AuthController@login');