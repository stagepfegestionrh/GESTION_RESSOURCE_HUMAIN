<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('{path}',"HomeController@index")->where( 'path', '/^[a-z0-9]([0-9a-z_\-\s])+$/i' );
