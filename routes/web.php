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

Route::redirect('/', '/ecsite/menu');
Route::redirect('/ecsite', '/ecsite/menu');

Route::group(['prefix' => 'ecsite'], function () {
    Route::get('menu', 'MenuController@index')->name('ecsite.menu');
    Route::get('login', 'LoginController@index')->name('ecsite.login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->middleware('login')->name('ecsite.logout');;
    Route::get('register', 'RegisterController@index')->name('ecsite.register');
    Route::post('register', 'RegisterController@register');
    Route::get('registercheck', 'RegisterController@check')->name('ecsite.registercheck');
    Route::post('registercheck', 'RegisterController@send');
    Route::get('registerend', 'RegisterController@end')->name('ecsite.registerend');
    Route::get('product', 'ProductController@index')->name('ecsite.product');
    Route::get('productdetail/{id}', 'ProductController@detail')->name('ecsite.productdetail');
    Route::post('productdetail/{id}', 'ProductController@detailbuy');
    Route::get('cart', 'CartController@index')->name('ecsite.cart');
    Route::post('cart', 'CartController@check');
    Route::get('addcart', 'CartController@cartlist')->name('ecsite.addcart');
    Route::post('addcart', 'CartController@addcart');
    Route::get('buycheck', 'CartController@buycheck')->name('ecsite.buycheck');
    Route::post('buycheck', 'CartController@buy');
    Route::get('buyend', 'CartController@buyend')->name('ecsite.buyend');
});
