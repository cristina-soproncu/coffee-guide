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

/*Route::get('/', function () {
    return view('login');
});*/

Route::get('about','AboutController@index');
Route::get('blog','CoffeeController@index');
Route::get('contact','ContactController@index');
Route::get('login','LoginController@index');
Route::post('logout','LoginController@login');
Route::get('admin','AdminController@index');


Route::get('/add', 'LoginController@add');
Route::any('/store', 'LoginController@store');
Route::get('/{titlu}', 'LoginController@book');
Route::get('/delete/{titlu}', 'LoginController@delete');
Route::get('/edit/{titlu}', 'LoginController@edit');
Route::any('/updateData/{titlu}', 'LoginController@updateData');

