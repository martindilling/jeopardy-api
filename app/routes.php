<?php

App::bind('Jeopardy\Token\Generators\TokenGeneratorInterface', 'Jeopardy\Token\Generators\LaravelTokenGenerator');
App::bind('Jeopardy\Token\Repositories\TokenRepositoryInterface', 'Jeopardy\Token\Repositories\EloquentTokenRepository');
App::bind('Jeopardy\Token\Fetchers\TokenFetcherInterface', 'Jeopardy\Token\Fetchers\DefaultTokenFetcher');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return ErrorResponse::blah();
});

Route::group(array('prefix' => 'api/v1'), function()
{
	Route::get(   'token', 'ApiTokenController@index')->before('token');
	Route::post(  'token', 'ApiTokenController@store');
	Route::delete('token', 'ApiTokenController@destroy')->before('token');

	Route::get(   'users', function() { return ErrorResponse::noResourceListing(); });
	Route::post(  'users',   'UsersController@store');
	Route::get(   'profile', 'UsersController@show'); // users.show
	Route::post(  'profile', 'UsersController@update'); // users.update
	Route::delete('profile', 'UsersController@destroy'); // users.delete
	Route::get(   'users/{user_id}/games', 'GamesController@index');


	Route::get(   'games',      'GamesController@index'); // For authenticated user
	Route::post(  'games',      'GamesController@store');
	Route::get(   'games/{id}', 'GamesController@show');
	Route::post(  'games/{id}', 'GamesController@update');
	Route::delete('games/{id}', 'GamesController@destroy');
	Route::get(   'games/{game_id}/categories', 'CategoriesController@index');
	Route::get(   'games/{game_id}/difficulties', 'DifficultiesController@index');


	// Route::get(   'categories',      'CategoriesController@index');
	Route::get(   'categories', function() { return ErrorResponse::noResourceListing(); });
	// Route::get(   'categories', function() { App::abort(400, Config::get('errors.list_resource_not_available')); });
	Route::post(  'categories',      'CategoriesController@store');
	Route::get(   'categories/{id}', 'CategoriesController@show');
	Route::post(  'categories/{id}', 'CategoriesController@update');
	Route::delete('categories/{id}', 'CategoriesController@destroy');
	Route::get(   'categories/{category_id}/questions', 'QuestionsController@index');


	// Route::get(   'difficulties',      'DifficultiesController@index');
	Route::get(   'difficulties', function() { return ErrorResponse::noResourceListing(); });
	Route::post(  'difficulties',      'DifficultiesController@store');
	Route::get(   'difficulties/{id}', 'DifficultiesController@show');
	Route::post(  'difficulties/{id}', 'DifficultiesController@update');
	Route::delete('difficulties/{id}', 'DifficultiesController@destroy');


	// Route::get(   'questions',      'QuestionsController@index');
	Route::get(   'questions', function() { return ErrorResponse::noResourceListing(); });
	Route::post(  'questions',      'QuestionsController@store');
	Route::get(   'questions/{id}', 'QuestionsController@show');
	Route::post(  'questions/{id}', 'QuestionsController@update');
	Route::delete('questions/{id}', 'QuestionsController@destroy');

});
