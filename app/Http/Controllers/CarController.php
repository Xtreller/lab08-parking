<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\DiscountCards;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::pluck('registration')->toArray();
        return response()->json(['status' => 'ok', 'data' => $cars], 200);
    }

    /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request,Car $car): CarResource
    {
        $request_data = $request->all();
        $car->registration = $request_data['registration'];
        $car->type = $request_data['type'];
        $car->parking_places = $request_data['parking_places'];
        $car->save();

        return new CarResource($car);
    }
    public function show($registration)
    {
        $car = Car::with('parkings')->where('registration', $registration)->first();
        if (!is_null($car)) {
            return new CarResource($car);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'No such car!'], 404);
        }
    }


}
