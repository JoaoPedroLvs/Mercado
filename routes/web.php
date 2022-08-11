<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});

Route::group([], function(){ //Clientes

    Route::get('/customers',            'CustomerController@index');
    Route::get('/create/customer',      'CustomerController@create');
    Route::post('/form/customer',       'CustomerController@insert');
    Route::get('/edit/customer/{id}',   'CustomerController@edit');
    Route::put('/form/customer',        'CustomerController@update');
    Route::get('/delete/customer/{id}', 'CustomerController@delete');

    Route::get('/profile/customer/{id}', 'CustomerController@show');

});

Route::group([], function(){ //Categorias

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

Route::group([], function(){

    Route::get('/products',             'ProductController@index');

    Route::get('/create/product',       'ProductController@create');
    Route::post('/form/product',        'ProductController@insert');
    Route::get('/edit/product/{id}',    'ProductController@edit');
    Route::put('/form/product',         'ProductController@update');
    Route::get('/delete/product/{id}',  'ProductController@delete');

});
