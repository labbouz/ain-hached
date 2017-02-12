<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/setting', 'HomeController@setting')->name('setting');

Route::resource('users', 'UserController');
Route::resource('secteurs', 'SecteurController');
Route::resource('moves', 'MoveController');
Route::resource('structure_syndicale', 'StructureSyndicaleController');

Route::post('REST/users', 'UserController@getUsersJSON')->name('json.users.index');
Route::post('REST/secteurs', 'SecteurController@getElementsJSON')->name('json.secteurs.index');
Route::post('REST/moves', 'MoveController@getElementsJSON')->name('json.moves.index');
Route::post('REST/structure_syndicale', 'StructureSyndicaleController@getElementsJSON')->name('json.structure_syndicale.index');
