<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'tasks'], function () {
    Route::get('/all', [TaskController::class, 'index'])->middleware('jwt.verify');
    Route::get('/allByUser', [TaskController::class, 'taskByUser'])->middleware('jwt.verify');
    Route::post('/create', [TaskController::class, 'store'])->middleware('role:admin');
    Route::put('/update/description/{id}', [TaskController::class, 'update'])->middleware('role:admin');
    Route::put('/update/status/{id}', [TaskController::class, 'updateStatus'])->middleware('jwt.verify');
    Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->middleware('role:admin');
});


Route::group(['prefix' => 'users'], function () {
    Route::get('/all', [UserController::class, 'index'])->middleware('role:admin');
    Route::post('/create', [UserController::class, 'store'])->middleware('role:admin');
    Route::put('/reset-password', [UserController::class, 'update']);
    Route::post('/send-email', [UserController::class, 'SendEmail']);
});


Route::group(['prefix' => 'comments'], function () {
    Route::get('/task/{idTask}', [ComentController::class, 'getCommentsByTask'])->middleware('jwt.verify');
    Route::post('/create', [ComentController::class, 'store'])->middleware('jwt.verify');
    Route::delete('/delete/{commentId}', [ComentController::class, 'destroy'])->middleware('jwt.verify');
});


Route::post('/login', [AuthController::class, 'login']);
