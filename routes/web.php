<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    //Product Admin
    Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/products/save', 'App\Http\Controllers\ProductController@save')->name('product.save');
    Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@delete')->name('product.delete');

    //User Admin
    Route::get('/users', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('/users/create', 'App\Http\Controllers\UserController@create')->name('user.create');
    Route::post('/users/save', 'App\Http\Controllers\UserController@save')->name('user.save');
    Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');
    Route::get('/users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::put('/users/{id}', 'App\Http\Controllers\UserController@update')->name('user.update');
    Route::delete('/users/{id}', 'App\Http\Controllers\UserController@delete')->name('user.delete');
});

// Home 
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

// Product - Available to all (customers and guests)
Route::get('/products/{id}/show', 'App\Http\Controllers\ProductController@show')->name('product.show');

// Auth 
Auth::routes();

// Cart - Available to authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/cart', 'App\Http\Controllers\CartController@index')->name("cart.index");
    Route::get('/cart/delete', 'App\Http\Controllers\CartController@delete')->name("cart.delete");
    Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name("cart.add");
});

// Reviews - Nested under products
// Authenticated users can create, edit, and delete their own reviews
Route::middleware('auth')->group(function () {
    Route::get('/products/{productId}/reviews/create', 'App\Http\Controllers\ReviewController@create')->name('review.create');
    Route::post('/products/{productId}/reviews', 'App\Http\Controllers\ReviewController@store')->name('review.store');
    Route::get('/products/{productId}/reviews/{reviewId}/edit', 'App\Http\Controllers\ReviewController@edit')->name('review.edit');
    Route::put('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@update')->name('review.update');
    Route::delete('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@destroy')->name('review.destroy');
});

// All users can view reviews (guests and authenticated)
Route::get('/products/{productId}/reviews', 'App\Http\Controllers\ReviewController@index')->name('review.index');
Route::get('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@show')->name('review.show');