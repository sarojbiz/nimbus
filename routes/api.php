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
Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\AuthController@login');
Route::resource('product', 'API\ProductController');
Route::resource('category', 'API\CategoryController');
Route::resource('size', 'API\SizeController');
Route::resource('color', 'API\ColorController');

Route::middleware('auth:api')->group( function () {
	Route::get('cart', 'API\CartController@index');
	Route::post('cart/update', 'CartController@update');
	Route::post('cart/add', 'CartController@add');
	Route::post('cart/remove', 'CartController@remove');

	Route::post('size/update/{id}', 'API\SizeController@update');
	Route::get('size/delete/{id}', 'API\SizeController@delete');

	Route::post('color/update/{id}', 'API\ColorController@update');
	Route::get('color/delete/{id}', 'API\ColorController@delete');	

	Route::post('category/update/{id}', 'API\CategoryController@update');
	Route::get('category/delete/{id}', 'API\CategoryController@delete');
	
	Route::post('product/update/{mcode}', 'API\ProductController@update');
	Route::get('product/delete/{mcode}', 'API\ProductController@delete');

	Route::post('barcode/update/{barcode}', 'API\BarcodeController@update');
	Route::get('barcode/delete/{barcode}', 'API\BarcodeController@delete');
	Route::resource('barcode', 'API\BarcodeController');	
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
