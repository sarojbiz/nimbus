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
include('backend.php');

Route::get('uploads/{assetType}/{file_path}', 'UploadController@getFile')->where('file_path', '(.*)'); // allow slash(/) to be part of file_path

Route::get('/', 'HomeController@index')->name('front');