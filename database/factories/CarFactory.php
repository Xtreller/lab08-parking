<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    public function definition()
    {
        return [
            'registration' => $this->faker->randomNumber(6),
            'type' => $this->faker->randomNumber(1, 3),
            'parking_places' => $this->faker->numberBetween(1, 3),
            'discount_card_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
