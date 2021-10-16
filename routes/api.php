<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/bookables',\App\Http\Controllers\Api\BookableController::class)->only(['index','show']);
Route::get('bookables/{bookable}/availability',\App\Http\Controllers\Api\BookableAvailabilityController::class)
    ->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews',\App\Http\Controllers\Api\BookableReviewController::class)
    ->name('bookables.reviews.show');

Route::apiResource('reviews',\App\Http\Controllers\Api\ReviewController::class)->only(['show','store']);
Route::get('/booking-by-review/{reviewKey}',\App\Http\Controllers\Api\BookingByReviewController::class)
    ->name('booking.by-review.show');

Route::get('bookables/{bookable}/price',\App\Http\Controllers\Api\BookablePriceController::class)
    ->name('bookables.price.show');

Route::post('checkout',\App\Http\Controllers\Api\CheckoutController::class);
