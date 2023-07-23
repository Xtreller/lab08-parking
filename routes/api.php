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
    //Car
    Route::get('cars',[CarController::class,'index']);
    Route::get('get_amount/{car}',[CarController::class,'show']);
    Route::post('/register_car',[CarController::class,'store']);

    //Parking
    Route::get('free_spaces',[ParkingController::class,'show']);
    Route::post('car_enters',[ParkingController::class,'store']);
    Route::post('car_exits',[ParkingController::class,'update']);

});
