<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['*'];
    public const ADD_UPDATE_RULES = [
        'registration' => 'required',
        'type' => 'required|min:1',
        'parking_place' => 'required|min:1',

    ];
    public function car_type(){
        return $this->hasOne(CarType::class,'id','type');
    }
}
