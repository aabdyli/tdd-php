<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

// Threads
Route::get('threads', 'ThreadsController@index');
Route::post('threads', 'ThreadsController@store');
Route::get('threads/create', 'ThreadsController@create');
Route::get('threads/{channel}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

// Replies
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::delete('replies/{reply}', 'RepliesController@destroy');

// Favorites
Route::post('replies/{reply}/favorites', 'FavoritesController@store');

// Profiles
Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');

Route::get('home', 'HomeController@index')->name('home');
