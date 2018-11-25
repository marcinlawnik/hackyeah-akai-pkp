<?php

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

Route::get('/', function () {
    return view('chat');
});

Route::post('/picture', 'PictureController@store');

Route::get('/picture/', function () {
    return App\Picture::all();
});

Route::post('/message', 'MessageController@store');
