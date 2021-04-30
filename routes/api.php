<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Public routes

//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    

    Route::post('/logout', [AuthController::class, 'logout']);
    
    //Taskes
    Route::get('/tareas/consultar', [TaskController::class, 'index']);
    Route::post('/tareas/crear', [TaskController::class, 'store']);
    Route::put('/tareas/actualizar/{id}', [TaskController::class, 'update']);
    Route::delete('/tareas/borrar/{id}', [TaskController::class, 'destroy']);
    Route::get('/tareas/consultar/{id}', [TaskController::class, 'show']);
    Route::get('/taskes/search/{description}', [TaskController::class, 'search']);
});