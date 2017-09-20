<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('threads', 'ThreadController@index');
Route::post('threads', 'ThreadController@store');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::post('replies/{reply}/favorites', 'FavoritesController@store');
