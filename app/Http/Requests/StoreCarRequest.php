<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'registration' => ['required', 'unique:cars,registration'],
            'type' => ['required', 'min:1'],
            'parking_places' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'registration.required' => 'Моля попълнете регистрационен номер!',
            'registration.unique' => 'Този регистрационен номер вече съществува!',
            'type' => 'Moля изберете тип!',
            'parking_places' => 'Моля попълнете нужните места за да се паркира колата!',
        ];
    }
}
