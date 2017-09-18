<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('threads', 'ThreadController@index');
Route::post('threads', 'ThreadController@store');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
