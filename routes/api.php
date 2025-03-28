<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TimeController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Ruta de prueba
    Route::apiResource('times', 'App\Http\Controllers\Api\V1\TimeController');

    // Rutas de manejo de jornada laboral
    // Ruta de inicio de la jornada
    Route::post('play', [TimeController::class, 'play']);
    // Ruta de pausa de la jornada
    // ********* HAY QUE PENSAR COMO SE VA A QUITAR LA PAUSA DE LA JORNADA *********
    Route::post('pause', [TimeController::class, 'pause']);
    // Ruta de fin de la jornada
    Route::post('stop', [TimeController::class, 'stop']);
});
