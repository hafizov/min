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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Short')
    ->as('short.')
    ->group(function () {
        Route::get('/{short}', 'ShortController@show')->name('show');
        Route::post('/', 'ShortController@store')->name('store');
    });
