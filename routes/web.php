<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home.index');

Route::get('/reviews', 'App\Http\Controllers\ReviewController@index')->name('review.index');
Route::get('reviews/create', 'App\Http\Controllers\ReviewController@create')->name('review.create');
Route::post('reviews/save', 'App\Http\Controllers\ReviewController@save')->name('review.save');
Route::get('reviews/{id}', 'App\Http\Controllers\ReviewController@show')->name('review.show');
Route::delete('/reviews/{id}', 'App\Http\Controllers\ReviewController@destroy')->name('review.destroy');
