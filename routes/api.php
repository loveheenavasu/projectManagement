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
    //project
    Route::post('add-project', [App\Http\Controllers\ProjectController::class, 'addProject']);
    Route::get('project-list', [App\Http\Controllers\ProjectController::class, 'projectList']);
    Route::get('project-detail/{id}', [App\Http\Controllers\ProjectController::class, 'projectDetail']);
    Route::post('update-project', [App\Http\Controllers\ProjectController::class, 'updateProject']);
    Route::get('project-delete/{id}', [App\Http\Controllers\ProjectController::class, 'projectDelete']);
    Route::post('assign-project', [App\Http\Controllers\ProjectController::class, 'projectAssign']);
    
    //role
     Route::get('role-list', [App\Http\Controllers\UsersController::class, 'roleList']);

     //Tasks
     Route::post('add-task', [App\Http\Controllers\TasksController::class, 'addTask']);
     Route::get('task-list/{id}', [App\Http\Controllers\TasksController::class, 'taskList']);
      Route::post('update-task', [App\Http\Controllers\TasksController::class, 'updatetask']);
    Route::get('task-delete/{id}', [App\Http\Controllers\TasksController::class, 'taskDelete']);
    Route::post('assign-task', [App\Http\Controllers\TasksController::class, 'assigntask']);
    Route::get('task-delete/{id}', [App\Http\Controllers\TasksController::class, 'taskDelete']);
    Route::get('task-detail/{id}', [App\Http\Controllers\TasksController::class, 'taskDetail']);
    Route::get('assign-task-delete/{id}', [App\Http\Controllers\TasksController::class, 'assigntaskDelete']);
    Route::get('user-task-list/{id}', [App\Http\Controllers\TasksController::class, 'usertaskList']);
     Route::post('update-task-status', [App\Http\Controllers\TasksController::class, 'updatetaskstatus']);
    
});
// Route::get('user-list', [App\Http\Controllers\UsersController::class, 'userList']);