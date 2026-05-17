<?php

use Illuminate\Support\Facades\Route;

Route::get('/products/in-stock', 'App\Http\Controllers\Api\ProductApiController@inStock')->name('api.products.in-stock');
