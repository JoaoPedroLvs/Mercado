<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/* Rotas de login, registro, resetar senha */

Route::group([], function() {

    Route::get   ('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post  ('/login', 'Auth\LoginController@login');
    Route::post  ('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get   ('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post  ('/register', 'Auth\RegisterController@register');

    Route::get   ('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post  ('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get   ('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post  ('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

});

Route::group(['middleware' => ['auth', 'permissions:customer,employee,manager']], function() {

    // Página inicial
    Route::get   ('/', 'HomeController@index');

    Route::get   ('/customer/{id}/show', 'CustomerController@show');
    Route::get   ('/person/{id}/edit', 'PersonController@edit');
    Route::put   ('/person', 'PersonController@update');

    /* Rotas para acesso de imagens */
    Route::get   ('/product/{id}/image', 'ImageController@showProduct');

    Route::put   ('/customer',        'CustomerController@update');
    Route::get   ('/categories',           ['uses' => 'CategoryController@index', 'role' => 'customer.index']);
    Route::get   ('/category/{id}/products', 'CategoryController@show');
    Route::get   ('/products',             'ProductController@index');
    Route::get   ('/promotions',           'PromotionController@index');
});

/* Rotas os usuários tem acesso */

Route::group(['middleware' => ['auth','permissions:customer,manager']], function() {


    /* Rotas para gerenciar o carrinho de compras */

    Route::get   ('/cart', 'ProductController@cart');
    Route::get   ('/add/cart/{id}', 'ProductController@addCart');
    Route::get   ('/remove/cart/{id}', 'ProductController@removeCart');
    Route::post  ('/sale',           'SaleController@insert');



});

/* Rotas que os funcionários tem acesso */
Route::group(['middleware' => ['auth', 'permissions:employee,manager']], function() {
    // Route::group(['middleware' => ['auth']], function() {

    /* Rota para quando criar um cliente criar uma pessoa */
    Route::post  ('/person', 'PersonController@insert');

    /* Rotas para gerenciar clientes */
    Route::get   ('/customers',            ['uses' => 'CustomerController@index', 'role' => 'customer.index']);
    Route::get   ('/customer/create',      'CustomerController@create');
    Route::post  ('/customer',       'CustomerController@insert');
    Route::get   ('/customer/{id}/delete', 'CustomerController@delete');
    Route::get   ('/customer/{id}/edit',   'CustomerController@edit');

    /* Rota para o funcionário acessar seu perfil */
    Route::get   ('/employee/{id}/show', 'EmployeeController@show');

    /* Rotas para gerenciar as categorias */
    Route::get   ('/category/create',      'CategoryController@create');
    Route::get   ('/category/{id}/edit',   'CategoryController@edit');
    Route::post  ('/category',       'CategoryController@insert');
    Route::put   ('/category',        'CategoryController@update');
    Route::get   ('/category/{id}/delete', 'CategoryController@delete');

    /* Rotas para gerenciar os produtos */
    Route::get   ('/product/create',       'ProductController@create');
    Route::get   ('/product/{id}/edit',    'ProductController@edit');
    Route::post  ('/product',        'ProductController@insert');
    Route::put   ('/product',         'ProductController@update');
    Route::get   ('/product/{id}/delete',  'ProductController@delete');

    /* Rotas para gerenciar os estoques */
    Route::get   ('/inventories',          'InventoryController@index');
    Route::get   ('/inventory/create',     'InventoryController@create');
    Route::post  ('/inventory',      'InventoryController@insert');
    Route::get   ('/inventory/{id}/delete',     'InventoryController@delete');


    /* Rotas para gerenciar as vendas */
    Route::get   ('/sales',                'SaleController@index');
    Route::get   ('/sale/{id}/products',   'SaleController@show');
    Route::get   ('/sale/create',             'SaleController@create');
    Route::get   ('/sale/{id}/delete',     'SaleController@delete');
    // Route::post  ('/sale',           'SaleController@insert');


});


Route::group(['middleware' => ['auth', 'permissions:manager']], function() {

    /* Rotas para gerenciar as pessoas */
    Route::get   ('/people', 'PersonController@index');
    Route::get   ('/person/create', 'PersonController@create');
    Route::get   ('/person/{id}/show', 'PersonController@show');
    Route::get   ('/person/{id}/delete', 'PersonController@delete');

    /* Rotas para gerenciar as promoções */
    Route::get   ('/promotion/create',     'PromotionController@create');
    Route::get   ('/promotion/{id}/edit',  'PromotionController@edit');
    Route::post  ('/promotion',      'PromotionController@insert');
    Route::put   ('/promotion',       'PromotionController@update');
    Route::get   ('/promotion/{id}/delete', 'PromotionController@delete');

    /* Rotas para gerenciar os funcionários */
    Route::get   ('/employees',            'EmployeeController@index');
    Route::get   ('/employee/create',      'EmployeeController@create');
    Route::get   ('/employee/{id}/delete', 'EmployeeController@delete');
    Route::get   ('/employee/{id}/edit',   'EmployeeController@edit');
    Route::post  ('/employee',       'EmployeeController@insert');
    Route::put   ('/employee',        'EmployeeController@update');

    /* Rotas para gerenciar os cargos de um funcionário */
    Route::get   ('/employees/roles', 'EmployeeRoleController@index');
    Route::get   ('/employees/role/{id}/details', 'EmployeeRoleController@show');
    Route::get   ('/employees/role/create', 'EmployeeRoleController@create');
    Route::get   ('/employees/role/{id}/edit', 'EmployeeRoleController@edit');
    Route::get   ('/employees/role/{id}/delete', 'EmployeeRoleController@delete');
    Route::post  ('/employees/role', 'EmployeeRoleController@insert');
    Route::put   ('/employees/role', 'EmployeeRoleController@update');

    /* Rotas para gerenciar os admins */
    Route::get   ('/admins', 'AdminController@index');
    Route::get   ('/admin/create', 'AdminController@create');
    Route::get   ('/admin/{id}/show', 'AdminController@show');
    Route::get   ('/admin/{id}/delete', 'AdminController@delete');
    Route::get   ('/admin/{id}/edit', 'AdminController@edit');
    Route::post  ('/admin', 'AdminController@insert');
    Route::put   ('/admin', 'AdminController@update');

    /* Rotas para criar usuários */
    Route::get  ('/users', 'UserController@index');
    Route::get  ('/user/{id}/show', 'UserController@show');
    Route::get  ('/user/create', 'UserController@create');
    Route::get  ('/user/{id}/edit', 'UserController@edit');
    Route::get  ('/user/{id}/delete', 'UserController@delete');
    Route::post ('/user', 'UserController@insert');
    Route::put  ('/user', 'UserController@update');

});
