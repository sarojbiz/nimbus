<?php
//Backend Routes
Route::group(['prefix' => 'admin', 'middleware' => ['adminPermission']], function() {
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::get('uploads/{assetType}/{file_path}', 'Admin\UploadController@getFile')->where('file_path', '(.*)'); // allow slash(/) to be part of file_path
    
    Route::resource('categories', 'Admin\CategoryController');
    Route::get('categories/delete/{category}', 'Admin\CategoryController@destroy');

    Route::resource('orders', 'Admin\OrderController');
    Route::get('orders/delete/{order}', 'Admin\OrderController@destroy');

    Route::resource('brands', 'Admin\BrandController');
    Route::get('brands/delete/{brand}', 'Admin\BrandController@destroy');

    Route::resource('banners', 'Admin\BannerController');
    Route::get('banners/delete/{banner}', 'Admin\BannerController@destroy');

    Route::resource('pages', 'Admin\PageController');
    Route::get('pages/delete/{page}', 'Admin\PageController@destroy');

    Route::resource('sizes', 'Admin\SizeController');
    Route::get('size/delete/{size}', 'Admin\SizeController@destroy');

    Route::resource('colors', 'Admin\ColorController');
    Route::get('color/delete/{color}', 'Admin\ColorController@destroy');

    Route::resource('admins', 'Admin\AdminController');
    Route::get('admin/delete/{admin}', 'Admin\AdminController@destroy');

    Route::resource('members', 'Admin\MemberController');
    Route::get('member/delete/{member}', 'Admin\MemberController@destroy');

    Route::get('products/export', 'Admin\ProductController@export');
    Route::get('products/import', 'Admin\ProductController@import');
    Route::post('products/import', 'Admin\ProductController@importStore');
    Route::get('products/sample_excel', 'Admin\ProductController@getSampleExcel');
    Route::resource('products', 'Admin\ProductController');
    Route::get('products/delete/{product}', 'Admin\ProductController@destroy');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('admin');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');
    Route::get('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
});