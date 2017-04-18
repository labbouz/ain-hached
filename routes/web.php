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

Route::group( ['middleware' => ['auth'] ], function (){

    Route::get('/', 'HomeController@index');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/setting', 'HomeController@setting')->name('setting');
    Route::get('/notacces', 'HomeController@notacces')->name('notacces');
    Route::get('/error', 'HomeController@error')->name('error');
    Route::resource('users', 'UserController');
    Route::match(['put', 'patch'], '/users/infosys/{user}','UserController@updateInfoSystem')->name('users.infosys');
    Route::match(['put', 'patch'], '/users/pass/{user}','UserController@updatePassword')->name('users.chnagepass');
    Route::match(['put', 'patch'], '/users/avatar/{user}','UserController@updateAvatar')->name('users.postavatar');
    Route::get('/roles/display/{id_role}', 'UserController@displayRole')->name('roles.display');
    Route::get('/roles/display/{id_role}/users/{id_inicateur}', 'UserController@display')->name('users.display');

    Route::resource('secteurs', 'SecteurController');
    Route::resource('conventions', 'ConventionController');
    Route::get('/conventions/display/{id_secteur}', 'ConventionController@display')->name('conventions.display');
    Route::resource('moves', 'MoveController');
    Route::resource('plaintes', 'PlainteController');
    Route::resource('medias', 'MediaController');
    Route::resource('structure_syndicale', 'StructureSyndicaleController');
    Route::resource('violations', 'ViolationController');
    Route::resource('type_societe', 'TypeSocieteController');
    Route::resource('delegations', 'DelegationController');
    Route::get('/delegations/display/{id_gouvernorat}', 'DelegationController@display')->name('delegations.display');

    Route::resource('societes', 'SocieteController');
    Route::match(['put', 'patch'], '/societes/convention/{societe}','SocieteController@updateConvention')->name('societes.chnageconvention');

    Route::get('/societes/{societe}/dossiers','SocieteController@showDossiers')->name('societe.show.dossiers');

    Route::post('REST/users/{id_role}/{id_inicateur?}', 'UserController@getElementsJSON')->name('json.users.index');
    Route::post('REST/observateurs/', 'UserController@getElementsJSONviaRegion')->name('json.observateurs.index');
    Route::post('REST/secteurs', 'SecteurController@getElementsJSON')->name('json.secteurs.index');
    Route::post('REST/moves', 'MoveController@getElementsJSON')->name('json.moves.index');
    Route::post('REST/plaintes', 'PlainteController@getElementsJSON')->name('json.plaintes.index');
    Route::post('REST/medias', 'MediaController@getElementsJSON')->name('json.medias.index');
    Route::post('REST/structure_syndicale', 'StructureSyndicaleController@getElementsJSON')->name('json.structure_syndicale.index');
    Route::post('REST/violations', 'ViolationController@getElementsJSON')->name('json.violations.index');
    Route::post('REST/gouvernorats', 'GouvernoratController@getElementsJSON')->name('json.gouvernorats.index');
    Route::post('REST/delegations/{id_gouvernorat}', 'DelegationController@getElementsJSON')->name('json.delegations.index');
    Route::post('REST/conventions/{id_secteur}', 'ConventionController@getElementsJSON')->name('json.conventions.index');
    Route::post('REST/type_societe', 'TypeSocieteController@getElementsJSON')->name('json.type_societe.index');


    Route::get('/societes/secteur/{id_secteur}', 'SocieteController@showRegionByAdmin')->name('societes_secteur.admin');
    Route::get('/societes/secteur/{id_secteur}/gouvernorat/{id_gouvernorat}', 'SocieteController@showDelegationByAdmin')->name('societes_region.admin');
    Route::get('/societes/secteur/{id_secteur}/delegation/{id_delegation}', 'SocieteController@showSocietesByAdmin')->name('societes.display.admin');

    Route::get('/societes/secteur-regional/{id_secteur}', 'SocieteController@showDelegationRegional')->name('societes_secteur.observateur_region');
    Route::get('/societes/secteur-regional/{id_secteur}/{id_delegation}', 'SocieteController@showSocietesByObservateurRegional')->name('societes_regional.display');

    Route::get('/societes/region-sectorial/{id_gouvernorat}', 'SocieteController@showDelegationSectorial')->name('societes_regional.observateur_secteur');
    Route::get('/societes/region-sectorial/delegation/{id_delegation}', 'SocieteController@showSocietesByObservateurSectorial')->name('societes_sectorial.display');

    Route::post('REST/societes/{id_secteur}/{id_delegation}', 'SocieteController@getElementsJSONviaRegion')->name('json.region.societes.index');

    Route::get('REST/societes/')->name('json.region.societes.get.url');


    // Dossiers Dashboard
    Route::get('/dossiers', 'HomeController@dashboardDossiers')->name('dashboard.dossiers');
    Route::get('/dossier/add', 'HomeController@dashboardDossiers')->name('dossier.add');

    Route::resource('dossier', 'DossierController');

    //Abus
    Route::get('/dossier/abus/{dossier}', 'DossierController@gestionAbus')->name('dossier.gestion');

});



