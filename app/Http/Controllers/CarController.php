<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Resources\CarCollectionResource;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\DiscountCards;
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
    public function index(Car $car): CarCollectionResource
    {
        return new CarCollectionResource($car);
    }

    /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request, Car $car): CarResource
    {
        $request_data = $request->all();
        $car->registration = $request_data['registration'];
        $car->type = $request_data['type'];
        $car->parking_places = $request_data['parking_places'];
        $discount = DiscountCards::where('id',$request_data['discount_card'])->orWhere('name',$request_data['discount_card'])->first();
        $car->discount_card_id = $discount->id;
        $car->save();

        return new CarResource($car);
    }
    public function show(Car $car)
    {
        return new CarResource($car);
    }


}
