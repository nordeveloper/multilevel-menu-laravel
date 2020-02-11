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

Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/menu/add', 'HomeController@menuAdd')->name('homeMenuAdd');
    Route::get('/menu/{id}/delete', 'HomeController@menuDelete')->name('homeMenuDelete');   
});

Route::get('/{slug}', 'PageController@page')->name('page');