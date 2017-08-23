<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...

	Route::get('/', function () {
	    return redirect('/user');
	});

	Route::get('/user', 'Auth\AuthController@getLogin');
	Route::post('/user', 'Auth\AuthController@postLogin');
	Route::get('/logout', 'Auth\AuthController@getLogout');

// Registration routes...

	Route::get('/register', 'Auth\RegisterController@getRegister');
	Route::post('/register', 'Auth\RegisterController@postRegister');

	Route::controllers([
	   'password' => 'Auth\PasswordController',
	]);

/*Creator*/

	Route::get('/creator', 'CreatorController@index');

	Route::get('/creator/create', 'CreatorController@create');
	Route::post('/creator', 'CreatorController@store');

	Route::get('/creator/edit/{creator_id}', 'CreatorController@edit');
	Route::post('/creator/edit/{creator_id}', 'CreatorController@update');

	Route::get('/creator/delete/{creator_id}', 'CreatorController@delete');

/*End-Creator*/

/*Genre*/

	Route::get('/genre', 'GenreController@index');

	Route::get('/genre/create', 'GenreController@create');
	Route::post('/genre', 'GenreController@store');

	Route::get('/genre/delete/{genre_id}', 'GenreController@delete');

/*End-Genre*/




/*Language*/

	Route::get('/language', 'LanguageController@index');

	Route::get('/language/create', 'LanguageController@create');
	Route::post('/language', 'LanguageController@store');

	Route::get('/language/delete/{language_id}', 'LanguageController@delete');

/*End-Language*/

/*Person*/

	Route::get('/person', 'PersonController@index');

	Route::get('/person/create', 'PersonController@create');
	Route::get('/person/create/getcitylist/{country_id}','PersonController@getCityList');
	Route::post('/person', 'PersonController@store');
	Route::get('/person/edit/{person_id}', 'PersonController@edit');
	Route::post('/person/edit/{person_id}', 'PersonController@update');
	Route::get('/person/delete/{person_id}', 'PersonController@delete');

/*End-Person*/
/*Character*/

	Route::get('/character', 'CharacterController@index');
	Route::get('/character/create', 'CharacterController@create');
	Route::post('/character', 'CharacterController@store');
	Route::get('/character/edit/{characte_id}', 'CharacterController@edit');
	Route::post('/character/edit/{characte_id}', 'CharacterController@update');
	Route::get('/character/delete/{characte_id}', 'CharacterController@delete');

/*End-Character*/

/*Series*/

	Route::get('/series', 'SeriesController@index');

	Route::get('/series/create', 'SeriesController@create');
	Route::post('/series', 'SeriesController@store');

	Route::get('/series/edit/{series_id}', 'SeriesController@edit');
	Route::post('/series/edit/{series_id}', 'SeriesController@update');

	Route::get('/series/delete/{series_id}', 'SeriesController@delete');

/*End-Series*/

/*Season*/

	Route::get('/season', 'SeasonController@index');

	Route::get('/season/create', 'SeasonController@create');
	Route::post('/season', 'SeasonController@store');

	Route::get('/season/edit/{season_id}', 'SeasonController@edit');
	Route::post('/season/edit/{season_id}', 'SeasonController@update');

	Route::get('/season/delete/{season_id}', 'SeasonController@delete');

/*End-Season*/

/*Episode*/

	Route::get('/episode', 'EpisodeController@index');

	Route::get('/episode/create', 'EpisodeController@create');
	Route::get('/episode/create/getseasonlist/{series_id}','EpisodeController@getSeasonList');
	Route::get('/episode/edit/getseasonlist/{series_id}','EpisodeController@getSeasonList');
	Route::post('/episode', 'EpisodeController@store');

	Route::get('/episode/edit/{episode_id}', 'EpisodeController@edit');
	Route::post('/episode/edit/{episode_id}', 'EpisodeController@update');

	Route::get('/episode/delete/{episode_id}', 'EpisodeController@delete');

/*End-Episode*/


/*Users*/

	Route::get('/users', 'UsersController@index');

	Route::get('/users/edit/{email}', 'UsersController@edit');
	Route::post('/users/edit/{email}', 'UsersController@update');

	Route::get('/users/delete/{email}', 'UsersController@delete');

/*End-Users*/

/*Country*/

	Route::get('/country', 'CountryController@index');

	Route::get('/country/create', 'CountryController@create');
	Route::post('/country', 'CountryController@store');

	Route::get('/country/delete/{country_id}', 'CountryController@delete');

/*End-Country*/

/*City*/

	Route::get('/city', 'CityController@index');

	Route::get('/city/create', 'CityController@create');
	Route::post('/city', 'CityController@store');

	Route::get('/city/delete/{city_id}', 'CityController@delete');

/*End-City*/

/*soundtracks*/

	Route::get('/soundtracks', 'SoundtracksController@index');
	Route::get('/soundtracks/create', 'SoundtracksController@create');
	Route::post('/soundtracks', 'SoundtracksController@store');
	Route::get('/soundtracks/edit/{soundtracks_id}', 'SoundtracksController@edit');
	Route::post('/soundtracks/edit/{soundtracks_id}', 'SoundtracksController@update');
	Route::get('/soundtracks/delete/{soundtracks_id}', 'SoundtracksController@delete');
	Route::get('/soundtracks/create/getseasonlist/{series_id}','SoundtracksController@getSeasonList');
	Route::get('/soundtracks/edit/getseasonlist/{series_id}','SoundtracksController@getSeasonList');
	Route::get('/soundtracks/create/getepisodelist/{season_id}','SoundtracksController@getEpisodeList');
	Route::get('/soundtracks/edit/getepisodelist/{season_id}','SoundtracksController@getEpisodeList');

/*End-City*/
//Did you know 
	Route::get('/DidYouKnow','DidYouKnowController@index');

	Route::get('/DidYouKnow/create', 'DidYouKnowController@create');
	Route::post('/DidYouKnow', 'DidYouKnowController@store');
	
	Route::get('/DidYouKnow/edit/{episode_id}', 'DidYouKnowController@edit');
	Route::post('/DidYouKnow/edit/{episode_id}', 'DidYouKnowController@update');

	Route::get('/DidYouKnow/delete/{episode_id}', 'DidYouKnowController@delete');


//End-Did you know
