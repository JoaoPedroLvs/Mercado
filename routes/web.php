<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});

/* Rotas para gerenciar cliente */
Route::group([], function(){

    Route::get   ('/customers',            'CustomerController@index');
    Route::get   ('/customer/{id}/show', 'CustomerController@show');
    Route::get   ('/customer/create',      'CustomerController@create');
    Route::get   ('/customer/{id}/edit',   'CustomerController@edit');
    Route::post  ('/customer',       'CustomerController@insert');
    Route::put   ('/customer',        'CustomerController@update');
    Route::get   ('/customer/{id}/delete', 'CustomerController@delete');

});

/* Rotas para gerenciar funcionários */
Route::group([], function(){

    Route::get('/categories',           'CategoryController@index');

    Route::get('/create/category',      'CategoryController@create');
    Route::post('/form/category',       'CategoryController@insert');
    Route::get('/edit/category/{id}',   'CategoryController@edit');
    Route::put('/form/category',        'CategoryController@update');
    Route::get('/delete/category/{id}', 'CategoryController@delete');

    Route::get('category/{id}/products', 'CategoryController@show');
});

Route::group([], function() { //Funcionários

    Route::get('/employees',            'EmployeeController@index');

    Route::get('/create/employee',      'EmployeeController@create');
    Route::post('/form/employee',       'EmployeeController@insert');
    Route::get('/edit/employee/{id}',   'EmployeeController@edit');
    Route::put('/form/employee',        'EmployeeController@update');
    Route::get('/delete/employee/{id}', 'EmployeeController@delete');

    Route::get('/profile/employee/{id}', 'EmployeeController@show');

});

Route::group([], function(){ // Produtos

    Route::get('/products',             'ProductController@index');

    Route::get('/create/product',       'ProductController@create');
    Route::post('/form/product',        'ProductController@insert');
    Route::get('/edit/product/{id}',    'ProductController@edit');
    Route::put('/form/product',         'ProductController@update');
    Route::get('/delete/product/{id}',  'ProductController@delete');

});

Route::group([], function(){ //Estoque

    Route::get('/inventories',          'InventoryController@index');

    Route::get('/create/inventory',     'InventoryController@create');
    Route::post('/form/inventory',      'InventoryController@insert');
    Route::get('/delete/inventory/{id}',     'InventoryController@delete');

});

Route::group([], function(){ //Promoções

    Route::get('/promotions',           'PromotionController@index');

    Route::get('/create/promotion',     'PromotionController@create');
    Route::post('/form/promotion',      'PromotionController@insert');
    Route::get('/edit/promotion/{id}',  'PromotionController@edit');
    Route::put('/form/promotion',       'PromotionController@update');
    Route::get('/delete/promotion/{id}', 'PromotionController@delete');

});

Route::group([], function(){ //Vendas

    Route::get('/sales',                'SaleController@index');

    Route::get('/new/sale',             'SaleController@create');
    Route::post('/form/sale',           'SaleController@insert');
    Route::get('/delete/sale/{id}',     'SaleController@delete');

    Route::get('/sale/{id}/products',   'SaleController@show');

});
