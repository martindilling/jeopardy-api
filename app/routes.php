<?php

Route::get('/', function () {
    return 'nothing here';
});

Route::group(array('prefix' => 'api/v1'), function () {

    Route::get(   'token', 'ApiTokenController@index')->before('token');
    Route::post(  'token', 'ApiTokenController@store');
    Route::delete('token', 'ApiTokenController@destroy')->before('token');


    Route::post(  'users',   'UsersController@store');
    Route::get(   'profile', 'UsersController@show')->before('token');
    Route::post(  'profile', 'UsersController@update');  //TODO
    Route::delete('profile', 'UsersController@destroy'); //TODO
    Route::get(   'profile/games', 'GamesController@index')->before('token');


    Route::post(  'games',      'GamesController@store');   //TODO
    Route::get(   'games/{id}', 'GamesController@show')->before('token');
    Route::post(  'games/{id}', 'GamesController@update');  //TODO
    Route::delete('games/{id}', 'GamesController@destroy'); //TODO
    Route::get(   'games/{game_id}/categories', 'CategoriesController@index');     //TODO
    Route::get(   'games/{game_id}/difficulties', 'DifficultiesController@index'); //TODO


    Route::post(  'categories',      'CategoriesController@store');   //TODO
    Route::get(   'categories/{id}', 'CategoriesController@show');    //TODO
    Route::post(  'categories/{id}', 'CategoriesController@update');  //TODO
    Route::delete('categories/{id}', 'CategoriesController@destroy'); //TODO
    Route::get(   'categories/{category_id}/questions', 'QuestionsController@index'); //TODO


    Route::post(  'difficulties',      'DifficultiesController@store');   //TODO
    Route::get(   'difficulties/{id}', 'DifficultiesController@show');    //TODO
    Route::post(  'difficulties/{id}', 'DifficultiesController@update');  //TODO
    Route::delete('difficulties/{id}', 'DifficultiesController@destroy'); //TODO


    Route::post(  'questions',      'QuestionsController@store');   //TODO
    Route::get(   'questions/{id}', 'QuestionsController@show');    //TODO
    Route::post(  'questions/{id}', 'QuestionsController@update');  //TODO
    Route::delete('questions/{id}', 'QuestionsController@destroy'); //TODO

});
