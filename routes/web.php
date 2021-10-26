<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\View;

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

Auth::routes();

Route::middleware('auth')->get('/user' , function (Request $request) {
    return $request->user();
})->name('user');

Route::middleware('auth')->get('/home' , function (Request $request) {
    return View::make("welcome");
})->name('home');

Route::get('/login/{provider}', [AuthController::class,'redirectToProvider']);
Route::get('/login/{provider}/callback', [AuthController::class,'handleProviderCallback']);

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any','^(?!api\/)[\/\w\.-]*');




//Route::get('/bookables/{bookable}/price',\App\Http\Controllers\Api\BookablePriceController::class);
