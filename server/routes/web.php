<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login/twitter', 'Auth\LoginController@redirectToTwitterProvider')->name('login');
Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterProviderCallback')->name('callback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::resource('users', 'UserController')->only(['show']);
Route::group(['middleware' => ['auth']], function() {
    //Route::resource('todos', 'TodoController')->only(['show','store']);
});
Route::get('todos/{todo}', 'TodoController@show')->name('todos.show');
Route::post('todos', 'TodoController@store')->name('todos.store');
Route::post('todos/{id}/', 'TodoController@update')->name('todos.update');
Route::get('todos/{id}/ogp.png', 'TodoController@ogp');

Route::get('/home', 'HomeController@index')->name('home');
