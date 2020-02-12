<?php

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

Route::get('/', 'PageController@index');
Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::post('/menu/add', 'AdminController@add')->name('adminMenuAdd');
    Route::get('/menu/{id}/delete', 'AdminController@delete')->name('adminMenuDelete');   
});

Route::get('/{slug}', 'PageController@page')->name('page');