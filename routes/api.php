<?php
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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
Route::get('product', 'API\ProductController@index');
Route::get('product/{id}', 'API\ProductController@show');
Route::get('category', 'API\CategoryController@index');
Route::get('category/{id}', 'API\CategoryController@show');
Route::get('category/{id}/products', 'API\CategoryController@categoryProducts');
Route::get('size', 'API\SizeController@index');
Route::get('size/{id}', 'API\SizeController@show');
Route::get('color', 'API\ColorController@index');
Route::get('color/{id}', 'API\ColorController@show');
Route::get('barcode', 'API\BarcodeController@index');

Route::middleware('auth:api')->group( function () {
	Route::get('cart', 'API\CartController@index');
	Route::post('cart/update', 'CartController@update');
	Route::post('cart/add', 'CartController@add');
	Route::post('cart/remove', 'CartController@remove');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
