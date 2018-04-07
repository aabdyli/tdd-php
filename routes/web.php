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

// Subscription
Route::post('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

// Replies
Route::get('threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('replies/{reply}', 'RepliesController@update');
Route::delete('replies/{reply}', 'RepliesController@destroy');

// Favorites
Route::post('replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('replies/{reply}/favorites', 'FavoritesController@destroy');

// Profiles
Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get('profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('home', 'HomeController@index')->name('home');
Route::post('api/users/{user}/avatar', 'Api\UsersAvatarController@store')->name('avatar');
