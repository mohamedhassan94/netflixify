<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes();

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->where('provider', 'facebook|google');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('provider', 'facebook|google');

Route::get('movies', 'MovieController@index')->name('movies.all');

Route::get('movies/{id}', 'MovieController@show')->name('movies.watch');

Route::get('my_favorites', 'MovieController@favorite_movies')->name('movies.favorites')->middleware('auth');

Route::post('/movies/{id}/increment_views', 'MovieController@increment_views')->name('movies.increment_views');

Route::post('/movies/{id}/toggle_favorite', 'MovieController@toggle_favorite')->name('movies.toggle_favorite');


Route::get('profile/', 'ProfileController@edit')->name('edit_profile')->middleware('auth');
Route::post('profile/', 'ProfileController@update')->name('update_profile')->middleware('auth');

