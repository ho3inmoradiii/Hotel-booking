<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/bookables',\App\Http\Controllers\Api\BookableController::class)->only(['index','show']);
Route::get('bookables/{bookable}/availability',\App\Http\Controllers\Api\BookableAvailabilityController::class)
    ->name('bookables.availability.show');
