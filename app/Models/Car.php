<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    public function parkings(){
        return $this->hasMany(CarParkings::class)->whereNotNull('exit_time');
    }
    public function discount_card(){
        return $this->hasOne(DiscountCards::class,'id','discount_card_id');
    }
    protected function getDayPriceAttribute($value){
        return $this->car_type->day_price;
    }
    protected function getNightPriceAttribute($value){
        return $this->car_type->night_price;
    }
    protected function getDiscountPercentAttribute(){
        if(!is_null($this->discount_card)){
            return $this->discount_card->discount;
        }
    }
    protected function getTimeSpentAttribute(){
        $duration = 0;
        foreach($this->parkings as $parking){
            $duration += duration($parking->entry_time,$parking->exit_time);
        }
        return $duration;
    }
    protected function getAmountSpentAttribute()
    {
        $day_hrs = 0;
        $night_hrs = 0;
        foreach($this->parkings as $parking){
            $day_hrs += getDayNightHourCount($parking->entry_time,$parking->exit_time)['day'];
            $night_hrs += getDayNightHourCount($parking->entry_time,$parking->exit_time)['night'];
        }
        $amount = ($day_hrs * $this->day_price) + ($night_hrs * $this->night_price);
        return $amount;
    }
}
