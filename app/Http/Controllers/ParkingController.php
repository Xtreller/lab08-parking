<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarParkings;
use App\Models\CarsParking;
use App\Models\Parking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_free_spaces()
    {
        return response()->json(['free_spaces' => Parking::first()->free_spaces]);
    }
    public function car_enters($registration)
    {
        $car = Car::where('registration', $registration)->with('car_type')->first();
        $parking = Parking::first();
        $free_spaces = $parking->free_spaces;
        if (!is_null($car) && !is_null($parking)) {
            $car_parked = CarParkings::where('car_id', $car->id)->whereNull('exit_time')->first();
            if (is_null($car_parked)) {
                $car_parked = new CarParkings();
                $car_parked['car_id'] = $car->id;
                $car_parked['entry_time'] = Carbon::now();
                $car_parked->save();
                $free_spaces -= $car->car_type->space_needed;
                $parking['free_spaces'] = $free_spaces;
                $parking->save();
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Car ' . $car->registration . ' already parked!'], 409);
            }
        }

        return response()->json(['free_spaces' => $free_spaces]);
    }
    public function car_exits($registration)
    {
        $car = Car::where('registration', $registration)->with('car_type')->first();
        $parking = Parking::first();
        $free_spaces = $parking->free_spaces;
        if (!is_null($car) && !is_null($parking)) {
            $car_parked = CarParkings::where('car_id', $car->id)->whereNull('exit_time')->first();
            if (!is_null($car_parked)) {
                $car_parked['car_id'] = $car->id;
                $car_parked['exit_time'] = Carbon::now();
                $car_parked->save();
                $free_spaces += $car->car_type->space_needed;
                $parking['free_spaces'] = $free_spaces;
                $parking->save();
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Car ' . $car->registration . ' is not parked!'], 409);
            }
        }
        return response()->json(['free_spaces' => Parking::first()->free_spaces]);
    }
}
