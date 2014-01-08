<?php

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
	return View::make('hello');
});


Route::post(  'users',      'UsersController@store');
Route::get(   'users/{id}', 'UsersController@show');
Route::post(  'users/{id}', 'UsersController@update');
Route::delete('users/{id}', 'UsersController@destroy');


Route::post(  'games',      'GamesController@store');
Route::get(   'games/{id}', 'GamesController@show');
Route::post(  'games/{id}', 'GamesController@update');
Route::delete('games/{id}', 'GamesController@destroy');
Route::get(   'games',      'GamesController@index');
Route::get(   'games/{game_id}/categories', 'CategoriesController@index');
Route::get(   'games/{game_id}/difficulties', 'DifficultiesController@index');
Route::get(   'games/{game_id}/difficulties/{difficulty_id}/questions', 'QuestionsController@index');


Route::post(  'categories',      'CategoriesController@store');
Route::get(   'categories/{id}', 'CategoriesController@show');
Route::post(  'categories/{id}', 'CategoriesController@update');
Route::delete('categories/{id}', 'CategoriesController@destroy');
Route::get(   'categories',      'CategoriesController@index');


Route::post(  'difficulties',      'DifficultiesController@store');
Route::get(   'difficulties/{id}', 'DifficultiesController@show');
Route::post(  'difficulties/{id}', 'DifficultiesController@update');
Route::delete('difficulties/{id}', 'DifficultiesController@destroy');
Route::get(   'difficulties',      'DifficultiesController@index');


Route::post(  'questions',      'QuestionsController@store');
Route::get(   'questions/{id}', 'QuestionsController@show');
Route::post(  'questions/{id}', 'QuestionsController@update');
Route::delete('questions/{id}', 'QuestionsController@destroy');
Route::get(   'questions',      'QuestionsController@index');
