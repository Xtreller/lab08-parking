<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['*'];
    protected $primaryKey = 'registration';
    public $incrementing = false;
    protected $keyType = 'string';
    public function carType()
    {
        return $this->hasOne(CarType::class, 'id', 'type');
    }
    public function parkings()
    {
        return $this->hasMany(CarParkings::class)->whereNotNull('exit_time');
    }
    public function discountCard()
    {
        return $this->hasOne(DiscountCards::class, 'id', 'discount_card_id');
    }
    protected function getDayPriceAttribute($value)
    {
        // dd($this);
        return $value;
        // return $this->carType['day_price'];
    }
    protected function getNightPriceAttribute($value)
    {
        return $value;
        // return $this->carType['night_price'];
    }
    protected function getDiscountPercentAttribute()
    {
        if (!is_null($this->discount_card)) {
            return $this->discount_card->discount;
        }
        return 0;
    }
    protected function getTimeSpentAttribute()
    {
        $duration = 0;
        foreach ($this->parkings as $parking) {
            $duration += duration($parking->entry_time, $parking->exit_time);
        }
        return $duration;
    }
    protected function getDayHoursAttribute()
    {
        $day_hrs = 0;
        foreach ($this->parkings as $parking) {
            $day_hrs += getDayNightHourCount($parking->entry_time, $parking->exit_time)['day'];
        }
        return $day_hrs;
    }

    protected function getNightHoursAttribute()
    {
        $night_hrs = 0;
        foreach ($this->parkings as $parking) {
            $night_hrs += getDayNightHourCount($parking->entry_time, $parking->exit_time)['night'];
        }
        return $night_hrs;
    }

    protected function getAmountSpentAttribute()
    {
        $day_hrs = 0;
        $night_hrs = 0;
        foreach ($this->parkings as $parking) {
            $day_hrs += getDayNightHourCount($parking->entry_time, $parking->exit_time)['day'];
            $night_hrs += getDayNightHourCount($parking->entry_time, $parking->exit_time)['night'];
        }
        //assuming the discount is for the whole price;

        $amount = (($day_hrs * $this->day_price) + ($night_hrs * $this->night_price));
        if($amount == 0 && is_null($this->discount_percent)){
            $amount-=($amount * ($this->discount_percent/100));
        }
          return $amount;
    }
}
