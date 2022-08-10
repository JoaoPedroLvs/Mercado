<?php

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
