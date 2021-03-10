<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signup', 'Auth\RegisterController@register')->name('auth.register');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');
    Route::get('me', 'Auth\LoginController@me')->name('auth.me');
});
