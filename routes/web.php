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
    return view('welcome');
});

Route::get('/train_list', function () {
    return view('train_list');
});
Route::get('/purchase_site', function () {
    return view('purchase_site');
});
Route::get('/purchase', function () {
    return view('purchase');
});
Route::get('/sum_purchase', function () {
    return view('sum_purchase');
});
Route::get('/log', function () {
    return view('log');
});
Route::get('/payment', function () {
    return view('payment');
});
