<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('auth/logout', 'Auth\AuthController@logout')->name('auth.logout');
