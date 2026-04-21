<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    // Category Admin
    Route::get('/admin/categories/create', 'App\Http\Controllers\Admin\CategoryController@create')->name('category.create');
    Route::post('/admin/categories/save', 'App\Http\Controllers\Admin\CategoryController@save')->name('category.save');

    // Product Admin
    Route::get('/admin/products', 'App\Http\Controllers\Admin\ProductController@index')->name('product.index');
    Route::get('/admin/products/create', 'App\Http\Controllers\Admin\ProductController@create')->name('product.create');
    Route::post('/admin/products/save', 'App\Http\Controllers\Admin\ProductController@save')->name('product.save');
    Route::get('/admin/products/{id}/edit', 'App\Http\Controllers\Admin\ProductController@edit')->name('product.edit');
    Route::put('/admin/products/{id}', 'App\Http\Controllers\Admin\ProductController@update')->name('product.update');
    Route::delete('/admin/products/{id}', 'App\Http\Controllers\Admin\ProductController@delete')->name('product.delete');

    // User Admin
    Route::get('/admin/users', 'App\Http\Controllers\Admin\UserController@index')->name('user.index');
    Route::get('/admin/users/create', 'App\Http\Controllers\Admin\UserController@create')->name('user.create');
    Route::post('/admin/users/save', 'App\Http\Controllers\Admin\UserController@save')->name('user.save');
    Route::get('/admin/users/{id}', 'App\Http\Controllers\Admin\UserController@show')->name('user.show');
    Route::get('/admin/users/{id}/edit', 'App\Http\Controllers\Admin\UserController@edit')->name('user.edit');
    Route::put('/admin/users/{id}', 'App\Http\Controllers\Admin\UserController@update')->name('user.update');
    Route::delete('/admin/users/{id}', 'App\Http\Controllers\Admin\UserController@delete')->name('user.delete');
});

// Home
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

// Product - Available to all (customers and guests)
Route::get('/products/{id}/show', 'App\Http\Controllers\Admin\ProductController@show')->name('product.show');
Route::get('/products/search', 'App\Http\Controllers\Admin\ProductController@search')->name('product.search');

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

// Orders
Route::middleware('auth')->group(function () {
    Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('order.index');
    Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show')->name('order.show');
    Route::post('/orders', 'App\Http\Controllers\OrderController@save')->name('order.save');
    Route::put('/orders/{id}/cancel', 'App\Http\Controllers\OrderController@cancel')->name('order.cancel');
    Route::get('/orders/{id}/invoice', 'App\Http\Controllers\OrderController@downloadInvoice')->name('order.invoice');
});

// Payment
Route::middleware('auth')->group(function () {
    Route::get('/payment/{orderId}/create', 'App\Http\Controllers\PaymentController@create')->name('payment.create');
    Route::post('/payment/{orderId}', 'App\Http\Controllers\PaymentController@save')->name('payment.save');
    Route::get('/payment/{orderId}/success', 'App\Http\Controllers\PaymentController@success')->name('payment.success');
});
