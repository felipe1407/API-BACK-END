<?php

use App\Http\Controllers\Produto\CategoriaController;
use App\Http\Controllers\Produto\ProdutoController;
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
    Route::get('check', [LoginController::class, 'check'])->middleware('auth:sanctum');
});


Route::prefix('produto')->group(function(){
    Route::post('register_products', [ProdutoController::class, 'register_product']);
    Route::post('categoria', [CategoriaController::class, 'categoria']);
    Route::post('subCategoria', [CategoriaController::class, 'subCategoria']);
   
});

