<?php

namespace Database\Factories;

use App\Models\CarType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'space_needed' => $this->faker->numberBetween(1,3),
            'night_price' => $this->faker->randomFloat(2, 1, 1000),
            'day_price' => $this->faker->randomFloat(2, 1, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
