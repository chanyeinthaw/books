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

Route::prefix('')->name('books.')->group(function () {
    Route::get('/create', 'BookController@renderCreate')->name('create.render');
    Route::post('/create', 'BookController@create')->name('create');

    Route::get('/export', 'BookController@export')->name('export');

    Route::get('/', 'BookController@index')->name('index');
    Route::get('/{id}', 'BookController@get')->name('get');
    Route::delete('/{id}', 'BookController@delete')->name('delete');

    Route::get('/{id}/edit', 'BookController@renderUpdate')->name('update.render');
    Route::patch('/{id}/edit', 'BookController@update')->name('update');
});