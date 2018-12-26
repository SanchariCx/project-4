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
Route::post('/CreateAlbum','AlbumController@store')->middleware('auth');
Route::get('/ViewAlbum/{album}','ImageController@show')->middleware('auth');
Route::get('/FetchAlbum','AlbumController@show')->middleware('auth');
Route::post('/imageUpload','ImageController@store')->middleware('auth');
Route::post('/retrieve','ImageController@retrieve')->middleware('auth');
Route::get('/logout','UserController@logout');
Route::post('/delete','ImageController@destroy')->middleware('auth');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
