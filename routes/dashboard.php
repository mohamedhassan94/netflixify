<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Dashboard',
    'middleware' => ['auth', 'role:super_admin|admin']
], function () {

    Route::get('/', 'WelcomeController@index')->name('dashboard.welcome');  // the name here is dashboard.welcome

    Route::resource('categories', 'CategoryController');

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');

    Route::resource('movies', 'MovieController');

Route::get('/settings/social_login', 'SettingController@social_login')->name('settings.social_login');
Route::get('/settings/social_links', 'SettingController@social_links')->name('settings.social_links');

Route::get('/settings', function(){
    return redirect( route('dashboard.welcome') );
});

Route::post('/settings', 'SettingController@store')->name('settings.store');


});

