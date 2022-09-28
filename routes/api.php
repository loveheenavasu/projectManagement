<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth-login', [App\Http\Controllers\UsersController::class,'authenticate'])->name('authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
    
    Route::post('add-user', [App\Http\Controllers\UsersController::class, 'addUser']);
    Route::get('user-list', [App\Http\Controllers\UsersController::class, 'userList']);
    Route::get('user-detail/{id}', [App\Http\Controllers\UsersController::class, 'userDetail']);
    Route::post('update-user', [App\Http\Controllers\UsersController::class, 'updateUser']);
    Route::get('user-delete/{id}', [App\Http\Controllers\UsersController::class, 'userDelete']);
    
});