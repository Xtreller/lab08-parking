<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'/lab08'],function(){
    Route::get('cars',[CarController::class,'index']);
    Route::post('register_car',[CarController::class,'create']);

    Route::get('get_free_spaces',[ParkingController::class,'get_free_spaces']);
    Route::get('car_enters/{registration}',[ParkingController::class,'car_enters']);
    Route::get('car_exits/{registration}',[ParkingController::class,'car_exits']);

});
