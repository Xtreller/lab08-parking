<?php

namespace App\Rules;

use App\Models\DiscountCards;
use Illuminate\Contracts\Validation\Rule;

class DiscountExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value):bool
    {
        //
        $discount_card = DiscountCards::where('id',$value)->orWhere('name',$value)->first();
        if(!is_null($discount_card)){
            return true;
        }
        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Картата за остъпка се посочва по id (1,2 или 3) или по име (silver,gold или platinum)!';
    }
}
