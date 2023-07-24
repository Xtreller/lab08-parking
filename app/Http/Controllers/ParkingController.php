<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkCarRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Car;
use App\Models\CarParkings;
use App\Models\CarType;
use App\Models\Parking;
use Carbon\Carbon;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Parking $parking): ParkingResource
    {
        return new ParkingResource($parking::first());
    }
    public function store(ParkCarRequest $request, Car $car, CarParkings $car_parked)
    {
        $car = $car::where('registration', $request->all()['registration'])->with('carType')->first();
        $parking = Parking::first();

        $free_spaces = $parking->free_spaces;
        if (!is_null($car) && !is_null($parking)) {
            if ($free_spaces - $car->carType->space_needed < 0) {
                return response()->json(['status' => 'fail', 'message' => 'Няма свободни места!'], 422);
            }
            $car_parked = CarParkings::where('car_registration', $request['registration'])->whereNull('exit_time')->first();
            if (is_null($car_parked)) {
                $car_parked = new CarParkings();
                $car_parked['car_registration'] = $car->registration;
                $car_parked['entry_time'] = Carbon::now();
                $car_parked['space'] = $car->carType->space_needed;
                $car_parked->save();
                $free_spaces -= $car->carType->space_needed;
                $parking->update(['free_spaces' => $free_spaces]);
                return new ParkingResource($parking);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Кола с рег.номер ' . $car->registration . ' вече е паркирана!'], 422);
            }
        }
        return response()->json(['status' => 'fail', 'message' => 'Car or parking not initialized!'], 404);

    }
    public function update(ParkCarRequest $request, CarParkings $car_parked, Car $car)
    {
        $car = $car::where('registration', $request->all()['registration'])->with('carType')->first();
        $parking = Parking::first();

        $free_spaces = $parking->free_spaces;
        $parking = Parking::first();
        $free_spaces = $parking->free_spaces;
        if (!is_null($car) && !is_null($parking)) {
            $car_parked = CarParkings::where('car_registration', $car->registration)->whereNull('exit_time')->first();
            if (!is_null($car_parked)) {
                $car_parked['car_registration'] = $car->registration;
                $car_parked['exit_time'] = Carbon::now();
                $car_parked->save();
                $free_spaces += $car->carType->space_needed;
                $parking->update(['free_spaces' => $free_spaces]);
                return new ParkingResource($parking);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Кола с рег.номер ' . $car->registration . ' не е паркирана!'], 422);
            }
        }
        return response()->json(['status' => 'fail', 'message' => 'Car or parking not initialized!'], 404);
    }
}
