<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
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
        $cars = Car::all();
        return response()->json(['status'=>'ok','data'=>$cars],200);
    }

      /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create():JsonResponse
    {
        $data = $this->request->all();
        $car = new Car();
        $car['registration']=$data['registration'];
        $car['type']=$data['type'];
        $car['parking_places']=$data['parking_places'];
        isset($data['discount_card_id']) && $data['discount_card'] != ''? $car['discount_card']=$data['discount_card']:"";
        $car->save();
        return response()->json(['status'=>'ok','data'=>$car]);
    }
    public function get_amount($registration){
            $car = Car::with('parkings')->where('registration',$registration)->first();
            if(!is_null($car)){
                return response()->json(['status'=>'ok','amount_spent'=>number_format($car->amount_spent,2,'.','').'лв','time_spent'=>$car->time_spent.' пълни часа и може би няколко минути. 😉'],200);
            }
            else{
                return response()->json(['status'=>'fail','message'=>'No such car!'],404);
            }
    }
    //TODO


}
