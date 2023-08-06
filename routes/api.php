<?php

use App\Http\Controllers\HeaderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarouselController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//todo: Api Authentication
//Route::post('/register', [AuthApiController::class, 'register']);
//Route::post('/login', [AuthApiController::class, 'login']);

//Route::middleware('auth:sanctum')->group(function () {
//    Route::post('logout', [AuthApiController::class,'logout']);
//    Route::get('users', function (Request $request) {
//        return $request->user();
//    });
//});
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::get('refresh', 'refresh');

});
Route::middleware('auth:api')->group(function () {
    Route::get('getCarousel', [CarouselController::class, 'get']);
    Route::post('storeCarousel', [CarouselController::class, 'store']);
    Route::put('updateCarousel/{id}', [CarouselController::class, 'update']);
    Route::delete('deleteCarousel/{id}', [CarouselController::class, 'delete']);
//  todo: get Page
    Route::get('getHeaders', [HeaderController::class, 'get']);
    Route::post('storeHeader', [HeaderController::class, 'store']);
    Route::put('updateHeader/{id}', [HeaderController::class, 'update']);
    Route::delete('deleteHeader/{id}', [HeaderController::class, 'delete']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
