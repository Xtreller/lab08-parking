<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        // dd($this);
        return [
            'status' => 'ok',
            'car' => $this->registration,
            'day_hrs' => $this->day_hours,
            'night_hrs' => $this->night_hours,
            'discount' => !is_null($this->discountCard) ? $this->discountCard->discount . '%' : "",
            'amount_spent' => number_format($this->amount_spent, 2, '.', '') . 'лв',
            'time_spent' => $this->time_spent . 'ч.'
        ];
    }
}
