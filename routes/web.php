<?php

Route::get('/', 'PostsController@index')->name('home');
Route::get('home', 'PostsController@index');
Route::get('/{user}/posts/', 'PostsController@show_all_users_posts');
Route::get('/posts/create','PostsController@create');
Route::post('/posts','PostsController@store');
Route::get('/posts/{post}', 'PostsController@show');
Route::get('/posts/edit/{post}', 'PostsController@edit');
Route::get('/add_img', 'PostsController@add_image');
Route::post('/update', 'PostsController@update');
Route::post('/delete', 'PostsController@delete');
Route::get('/show_words_filter', 'PostsController@show_words_filter');
Route::post('/store_words_filter', 'PostsController@store_words_filter');
Route::post('/update_words_filter', 'PostsController@update_words_filter');

Route::post('/like', 'LikesController@like');
Route::post('/unlike', 'LikesController@unlike');


Route::post('/posts/{post}/comments', 'CommentsController@store');


Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

