<?php

namespace App\Rules;

use App\Models\DiscountCards;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class StoreCar implements Rule,DataAwareRule
{
    protected $data = [];
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
    public function passes($attribute, $value)
    {
        if (isset($this->data['discount_card']) && $this->data['discount_card'] != '') {
            $card = DiscountCards::find($this->data['discount_card']);
            if (is_null($card)) {
                return response()->json(['status' => 'fail', 'message' => 'Discount card doesn\'t exists!']);
            }
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
        return 'The validation error message.';
    }
    public function setData($data){
        $this->data = $data;
        return $this;
    }
}
