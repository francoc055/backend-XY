<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'tasks'], function () {
    Route::get('/all', [TaskController::class, 'index']);
    Route::post('/create', [TaskController::class, 'store']);
    Route::put('/update/description', [TaskController::class, 'update']);
    Route::put('/update/status', [TaskController::class, 'updateStatus']);
});


Route::group(['prefix' => 'users'], function () {
    Route::post('/create', [UserController::class, 'store']);
    Route::put('/reset-password', [UserController::class, 'update']);
    Route::post('/send-email', [UserController::class, 'SendEmail']);
});


Route::group(['prefix' => 'comments'], function () {
    Route::get('/task/{idTask}', [ComentController::class, 'getCommentsByTask']);
    Route::post('/create', [ComentController::class, 'store']);
    Route::delete('/delete/{commentId}', [ComentController::class, 'destroy'])->middleware('jwt.verify');
});


Route::post('/login', [AuthController::class, 'login']);