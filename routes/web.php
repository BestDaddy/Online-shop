<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Web'] , function () {

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
        Route::resource('items', 'ItemsController', ['only' => ['index', 'show', 'store', 'edit']]);
        Route::resource('categories', 'CategoriesController', ['only' => ['index', 'show', 'store', 'edit', 'destroy']]);
        Route::resource('subcategories', 'SubcategoriesController', ['only' => ['show', 'store', 'edit', 'destroy']]);

        Route::get('/categories-subcategories', 'CategoriesController@categoriesWithSubcategories')->name('categoriesWithSubcategories');
    });
});

