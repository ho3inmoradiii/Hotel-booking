<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('bookables',[\App\Http\Controllers\BookableController::class,'bookables']);
//Route::get('bookables/{id}',[\App\Http\Controllers\BookableController::class,'show']);

Route::apiResource('/bookables',\App\Http\Controllers\Api\BookableController::class)->only(['index','show']);
