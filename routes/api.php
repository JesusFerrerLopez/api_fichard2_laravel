<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('test', function () {
    return 'Hello World';
});

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('times', 'App\Http\Controllers\Api\V1\TimeController');
});
