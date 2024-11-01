<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('usuario')->group(function(){
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
});