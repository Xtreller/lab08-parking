<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarAmountResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status' => 'ok',
            'car'=>$this,
            'day_hrs' => $this->day_hours,
            'night_hrs' => $this->night_hours,
            'amount_spent' => number_format($this->amount_spent, 2, '.', '') . 'лв',
            'time_spent' => $this->time_spent . 'ч.'
        ];
    }
}
