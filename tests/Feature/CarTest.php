<?php

namespace Tests\Feature;

use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_return_cars()
    {
        $this->get('/api/lab08/cars')
            ->assertJson(['data' => array()])
            ->assertOk();
    }
    public function test_register_car_registration_validation()
    {
        $response = $this->json('POST', 'api/lab08/register_car', []);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    "registration" => [
                        "Моля попълнете регистрационен номер!"
                    ],
                    "type" => [
                        "Moля изберете тип!"
                    ],
                    "parking_places" => [
                        "Моля попълнете нужните места за да се паркира колата!"
                    ]
                ],
            ]);

    }


    public function test_register_car()
    {

        $data = [
            'registration' => '000001',
            'type' => 1,
            'discount_card' => 2,
            "parking_places" => 2,
        ];
        // $this->post('/api/lab08/register_car', $data)
        //     ->assertStatus(201)
        //     ->assertJson(['data' => ['status' => 'ok']]);
        $response = $this->json('POST', 'api/lab08/register_car', $data);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => "Този регистрационен номер вече съществува!"
            ]);
    }
    public function test_car_resource_contains_expected_fields()
    {
        // Create a Car instance. You might need to modify this to match your actual Car model and its fields.
        $car = Car::factory()->create();

        // Create a CarResource instance from the Car instance.
        $carResource = (new CarResource($car))->resolve();

        // Assert that the CarResource contains the expected fields.
        $this->assertArrayHasKey('status', $carResource);
        $this->assertArrayHasKey('car', $carResource);
        $this->assertArrayHasKey('day_hrs', $carResource);
        $this->assertArrayHasKey('night_hrs', $carResource);
        $this->assertArrayHasKey('amount_spent', $carResource);
        $this->assertArrayHasKey('time_spent', $carResource);
    }
}
