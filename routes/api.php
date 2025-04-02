<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TimeController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
       // Rutas de manejo de jornada laboral
        // Ruta de inicio de la jornada
        Route::post('play', [TimeController::class, 'play']);

        // Ruta de pausa de la jornada
        Route::post('pause', [TimeController::class, 'pause']);

        // Ruta de fin de la jornada
        Route::post('stop', [TimeController::class, 'stop']);

        // Ruta de listado de jornadas de usuario específico según fechas
        Route::get('jornadas/resumen', [TimeController::class, 'resumen']);

        // Rutas de usuario
        // Ruta que recibe código y retorna un usuario
        Route::get('user', [UserController::class, 'show']); 
        Route::patch('user', [UserController::class, 'update']);
        Route::delete('user', [UserController::class, 'destroy']);

        // Ruta que  maneja las peticiones relacionadas con varios usuarios
        Route::get('users', [UserController::class, 'index']);
    });

    // Ruta de login
    Route::post('login', [AuthController::class, 'login']);
});