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
Route::get('pages', 'API\CMSController@index');
Route::get('page/{id}', 'API\CMSController@show');
Route::get('banners', 'API\BannerController@index');
Route::get('banner/{id}', 'API\BannerController@show');
Route::get('barcode', 'API\BarcodeController@index');
Route::get('provinces', 'API\SettingController@getProvinceList');
Route::get('countries', 'API\SettingController@getCountryList');
Route::get('payment_methods', 'API\SettingController@getPaymentList');
Route::get('search/product', 'API\SearchController@productSearch');
Route::post('contact/save', function(Request $request){
	$request->validate([
		'contact_full_name' => 'required',
		'contact_email' => 'required',
		'contact_subject' => 'required',
		'contact_message' => 'required',
	]);
	return response()->json(['message' => 'Message sent successfully.'], 200);  

});

Route::middleware('auth:api')->group( function () {
	
	Route::get('user', 'API\UserProfileController@show');
	Route::post('checkout', 'API\CheckoutController@store');
	Route::get('myorders', 'API\MyOrderController@index');	
	Route::get('myorder/{order}', 'API\MyOrderController@show');	
	
});
