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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('product/{slug}', 'ProductController@index')->name('product');

//Auth::routes();
Route::match(['get','post'], 'login', 'AuthController@login')->name('user.login');
Route::match(['get','post'], 'register', 'AuthController@register')->name('user.register');
Route::get('/logout', 'AuthController@logout')->name('user.logout');
Route::match(['get','post'], 'forgot-password', 'AuthController@forgotPassword')->name('forgot.password');
Route::match(['get','post'],'verify-account', 'AuthController@otpVerification')->name('verify.account');

Route::get('cart', 'CartController@index')->name('cart');
Route::post('update_item', 'CartController@update')->name('update_item');
Route::post('add_item', 'AjaxcartController@add')->name('add_item');
Route::post('remove_item', 'AjaxcartController@remove')->name('remove_item');

Route::group(['namespace' => 'Shop', 'prefix' => 'wishlist'], function()
{
    Route::get('/', 'WishlistController@index')->name('front.wishlist.index');
    Route::post('/add', 'WishlistController@add')->name('front.wishlist.add');
    Route::post('/remove', 'WishlistController@remove')->name('front.wishlist.remove');
});

/*single product page starts*/
Route::post('add_single_product', 'CartController@add')->name('add_single_product');
Route::get('autocomplete', 'ProductController@autocomplete')->name('autocomplete');
/*single product page ends*/

/*categories routes starts*/
Route::get('categories', 'CategoryController@index')->name('category.index');
Route::get('category/{category_slug}', 'CategoryController@show')->name('category.show');
/*categories routes ends*/

/*search page starts*/
Route::get('search', 'SearchController@index')->name('search');
/*search page ends*/

Route::get('checkout', 'CheckoutController@index')->name('checkout');
Route::post('checkout/store', 'CheckoutController@store')->name('process.checkout');
Route::get('checkout/thankyou', 'CheckoutController@thankyou')->name('checkout.thankyou');

/*product review*/
Route::post('review/save', 'ReviewController@store')->name('front.review.save');

Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index');
    Route::get('profile', 'ProfileController@index');
    Route::post('update-profile', 'ProfileController@update');
    Route::get('addressbook', 'AddressbookController@index');
    Route::post('update-addressbook', 'AddressbookController@update');
    Route::get('orders', 'OrderController@index');
});