<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\Produto\CategoriaController;
use App\Http\Controllers\Produto\ProdutoController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('usuario')->group(function(){
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    Route::get('check', [LoginController::class, 'check'])->middleware('auth:sanctum');
    Route::get('users', [LoginController::class, 'show'])->middleware('auth:sanctum')->name('listUsers');
    Route::put('/update/{id}', [LoginController::class, 'update'])->middleware('auth:sanctum')->name('editUsers');
    Route::delete('/delete/{id}', [LoginController::class, 'destroy'])->middleware('auth:sanctum')->name('deleteUsers');
});


Route::prefix('produto')->group(function(){
    Route::post('register_products', [ProdutoController::class, 'register_product'])->middleware('auth:sanctum');
    Route::get('index', [ProdutoController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/{produto}', [ProdutoController::class, 'show'])->middleware('auth:sanctum');
    Route::put('/{id}', [ProdutoController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [ProdutoController::class, 'destroy'])->middleware('auth:sanctum');
   
});

Route::prefix('categoria')->group(function(){
    Route::post('register', [CategoriaController::class, 'categoria'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [CategoriaController::class, 'destroy'])->middleware('auth:sanctum')->name('deleteCategoria');
    Route::post('subCategoria', [CategoriaController::class, 'subCategoria'])->middleware('auth:sanctum');
});

Route::prefix('carrinho')->group(function(){
    Route::get('/', [CarrinhoController::class, 'list_car'])->middleware('auth:sanctum');
     Route::delete('/{id}', [CategoriaController::class, 'removeCar'])->middleware('auth:sanctum')->name('delete');
     Route::post('/{id}', [CarrinhoController::class, 'addCar'])->middleware('auth:sanctum');
});


