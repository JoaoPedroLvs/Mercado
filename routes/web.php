<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});

Route::group([], function(){ //Clientes

    Route::get('/customers', [CustomerController::class, 'index']);

    Route::get('/create/customer', [CustomerController::class, 'create']);
    Route::post('/form/customer', [CustomerController::class, 'insert']);
    Route::get('/edit/customer/{id}', [CustomerController::class, 'edit']);
    Route::put('/form/customer', [CustomerController::class, 'update']);
    Route::get('/delete/customer/{id}', [CustomerController::class, 'delete']);

    Route::get('/profile/customer/{id}', [CustomerController::class, 'show']);

});

Route::group([], function(){ //Categorias

    Route::get('/categories', [CategoryController::class, 'index']);

    Route::get('/create/category', [CategoryController::class, 'create']);
    Route::post('/form/category', [CategoryController::class, 'insert']);
    Route::get('/edit/category/{id}', [CategoryController::class, 'edit']);
    Route::put('/form/category', [CategoryController::class, 'update']);
    Route::get('/delete/category/{id}', [CategoryController::class, 'delete']);

    // Route::get('category/{id}/products', [CategoryController::class, 'show']);
});
