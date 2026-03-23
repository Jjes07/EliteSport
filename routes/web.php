<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    // Product Admin
    Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/products/save', 'App\Http\Controllers\ProductController@save')->name('product.save');
    Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@delete')->name('product.delete');

    // User Admin
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
Route::get('/products/search', 'App\Http\Controllers\ProductController@search')->name('product.search');

// Auth
Auth::routes();

// Cart - Available to authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
    Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name('cart.add');
    Route::delete('/cart/remove/{id}', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
    Route::put('/cart/update/{id}', 'App\Http\Controllers\CartController@update')->name('cart.update');
    Route::delete('/cart/clear', 'App\Http\Controllers\CartController@delete')->name('cart.delete');
    Route::post('/cart/checkout', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout');
});

// Reviews
Route::middleware('auth')->group(function () {
    // Authenticated users can create, edit, and delete their own reviews
    Route::get('/products/{productId}/reviews/create', 'App\Http\Controllers\ReviewController@create')->name('review.create');
    Route::post('/products/{productId}/reviews', 'App\Http\Controllers\ReviewController@save')->name('review.save');
    Route::get('/products/{productId}/reviews/{reviewId}/edit', 'App\Http\Controllers\ReviewController@edit')->name('review.edit');
    Route::put('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@update')->name('review.update');
    Route::delete('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@delete')->name('review.delete');
});

// All users can view reviews
Route::get('/products/{productId}/reviews', 'App\Http\Controllers\ReviewController@index')->name('review.index');
Route::get('/products/{productId}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@show')->name('review.show');

//orders
Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('order.index');
Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show')->name('order.show');
Route::post('/orders', 'App\Http\Controllers\OrderController@store')->name('order.store');
Route::get('/orders/{id}/confirm', 'App\Http\Controllers\OrderController@confirm')->name('order.confirm');

// Payment routes
Route::middleware('auth')->group(function () {
    Route::get('/payment/{orderId}/create', 'App\Http\Controllers\PaymentController@create')->name('payment.create');
    Route::post('/payment/{orderId}', 'App\Http\Controllers\PaymentController@save')->name('payment.save');
    Route::get('/payment/{orderId}/success', 'App\Http\Controllers\PaymentController@success')->name('payment.success');
});