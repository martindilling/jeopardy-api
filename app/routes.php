<?php

Route::get('/', function () {
    return 'There is nothing to show here, as this is an API. Look in the "app/routes.php" file to see what routes you can use to interact with the API.';
});

Route::group(array('prefix' => 'api/v1'), function () {

    Route::get(   'token', 'ApiTokenController@index')->before('token');
    Route::post(  'token', 'ApiTokenController@store');
    Route::delete('token', 'ApiTokenController@destroy')->before('token');


    Route::post(  'users',   'UsersController@store');
    Route::get(   'profile', 'UsersController@show')->before('token');
    Route::post(  'profile', 'UsersController@update')->before('token');  //TODO
    Route::delete('profile', 'UsersController@destroy')->before('token'); //TODO
    Route::get(   'profile/games', 'GamesController@index')->before('token');


    Route::post(  'games',      'GamesController@store')->before('token');   //TODO
    Route::get(   'games/{id}', 'GamesController@show')->before('token');
    Route::post(  'games/{id}', 'GamesController@update')->before('token');  //TODO
    Route::delete('games/{id}', 'GamesController@destroy')->before('token'); //TODO
    Route::get(   'games/{game_id}/categories', 'CategoriesController@index')->before('token');     //TODO
    Route::get(   'games/{game_id}/difficulties', 'DifficultiesController@index')->before('token'); //TODO


    Route::post(  'categories',      'CategoriesController@store')->before('token');   //TODO
    Route::get(   'categories/{id}', 'CategoriesController@show')->before('token');    //TODO
    Route::post(  'categories/{id}', 'CategoriesController@update')->before('token');  //TODO
    Route::delete('categories/{id}', 'CategoriesController@destroy')->before('token'); //TODO
    Route::get(   'categories/{category_id}/questions', 'QuestionsController@index')->before('token'); //TODO


    Route::post(  'difficulties',      'DifficultiesController@store')->before('token');   //TODO
    Route::get(   'difficulties/{id}', 'DifficultiesController@show')->before('token');    //TODO
    Route::post(  'difficulties/{id}', 'DifficultiesController@update')->before('token');  //TODO
    Route::delete('difficulties/{id}', 'DifficultiesController@destroy')->before('token'); //TODO


    Route::post(  'questions',      'QuestionsController@store')->before('token');   //TODO
    Route::get(   'questions/{id}', 'QuestionsController@show')->before('token');    //TODO
    Route::post(  'questions/{id}', 'QuestionsController@update')->before('token');  //TODO
    Route::delete('questions/{id}', 'QuestionsController@destroy')->before('token'); //TODO

});
