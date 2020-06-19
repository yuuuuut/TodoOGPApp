<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('login/twitter', 'Auth\LoginController@redirectToTwitterProvider')->name('login');
Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterProviderCallback')->name('callback');
//Auth
Route::group(['middleware' => ['auth']], function() {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
/*
|--------------------------------------------------------------------------
| Todo Routes
|--------------------------------------------------------------------------
*/
//Auth
Route::group(['middleware' => ['auth']], function() {
    Route::get('todos/{todo}', 'TodoController@show')->name('todos.show');
    Route::post('todos', 'TodoController@store')->name('todos.store');
    Route::post('todos/delete/{todo}', 'TodoController@delete')->name('todos.delete');
    Route::post('todos/delete', 'TodoController@allDelete')->name('todos.allDelete');
    Route::post('todos/{id}/', 'TodoController@update')->name('todos.update');
    Route::get('todos/{id}/ogp.png', 'TodoController@ogp');
});
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
//Auth
Route::group(['middleware' => ['auth']], function() {
    Route::get('users/{nickname}', 'UserController@show')->name('users.show');
});
