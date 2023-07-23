<?php

namespace App\Http\Requests;

use App\Rules\StoreCarParkings;
use Illuminate\Foundation\Http\FormRequest;

class ParkCarRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'registration'=>['required','min:5'],
        ];
    }
    public function messages(){
        return [
            'registration.required'=>'Моля посочете регистрационен номер!',
            'registration.min'=>'Регистрационния номер трябва да е поне 5 символа!'
        ];
    }
}
