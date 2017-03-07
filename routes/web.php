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

Route::group( ['middleware' => ['auth','check.logout'] ], function (){

    Route::get('/', 'HomeController@index');

    Route::resource('users', 'UserController');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/setting', 'HomeController@setting')->name('setting');


    Route::match(['put', 'patch'], '/users/pass/{user}','UserController@updatePassword')->name('users.chnagepass');

    Route::get('/roles/display/{id_role}', 'UserController@displayRole')->name('roles.display');
    Route::get('/roles/display/{id_role}/users/{id_inicateur}', 'UserController@display')->name('users.display');

    Route::resource('secteurs', 'SecteurController');
    Route::resource('conventions', 'ConventionController');
    Route::get('/conventions/display/{id_secteur}', 'ConventionController@display')->name('conventions.display');
    Route::resource('moves', 'MoveController');
    Route::resource('structure_syndicale', 'StructureSyndicaleController');
    Route::resource('violations', 'ViolationController');
    Route::resource('delegations', 'DelegationController');
    Route::get('/delegations/display/{id_gouvernorat}', 'DelegationController@display')->name('delegations.display');


    Route::post('REST/users/{id_role}/{id_inicateur?}', 'UserController@getElementsJSON')->name('json.users.index');
    Route::post('REST/secteurs', 'SecteurController@getElementsJSON')->name('json.secteurs.index');
    Route::post('REST/moves', 'MoveController@getElementsJSON')->name('json.moves.index');
    Route::post('REST/structure_syndicale', 'StructureSyndicaleController@getElementsJSON')->name('json.structure_syndicale.index');
    Route::post('REST/violations', 'ViolationController@getElementsJSON')->name('json.violations.index');
    Route::post('REST/gouvernorats', 'GouvernoratController@getElementsJSON')->name('json.gouvernorats.index');
    Route::post('REST/delegations/{id_gouvernorat}', 'DelegationController@getElementsJSON')->name('json.delegations.index');
    Route::post('REST/conventions/{id_secteur}', 'ConventionController@getElementsJSON')->name('json.conventions.index');

});



