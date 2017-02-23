<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('auth/logout', 'Auth\AuthController@logout')->name('auth.logout');

Route::get('auth/facebook', 'Auth\FacebookController@redirect')->name('auth.fb.login');
Route::post('auth/facebook/deauth', 'Auth\FacebookController@deauth')->name('auth.fb.deauth');
Route::get('auth/facebook/callback', 'Auth\FacebookController@callback')->name('auth.fb.callback');
