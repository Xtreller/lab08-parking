<?php

namespace Tests\Feature;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\CarType;
use App\Models\DiscountCards;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;
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
        $car_type = CarType::factory()->create();
        $data = [
            'registration' => '000001',
            'type' => $car_type->id,
            "parking_places" => 2,
        ];
        $this->post('/api/lab08/register_car', $data)
            ->assertStatus(201)
            ->assertJson(['data' => ['status' => 'ok']]);
        $response = $this->json('POST', 'api/lab08/register_car', $data);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => "Този регистрационен номер вече съществува!"
            ]);
    }
    public function test_register_car_discount_validation()
    {

        $car_type = CarType::factory()->create();
        $data = [
            'registration' => '000001',
            'type' => $car_type->id,
            'discount_card' => 51345143,
            "parking_places" => 2,
        ];
        $this->json('POST', 'api/lab08/register_car', $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => "Картата за остъпка се посочва по id (1,2 или 3) или по име (silver,gold или platinum)!"
            ]);
    }
    public function test_car_resource_contains_expected_fields()
    {
        $car_type = CarType::factory()->create();
        $car = Car::factory()->create(['type'=>$car_type->id]);
        $carResource = (new CarResource($car))->resolve();

        $this->assertArrayHasKey('status', $carResource);
        $this->assertArrayHasKey('car', $carResource);
        $this->assertArrayHasKey('day_hrs', $carResource);
        $this->assertArrayHasKey('night_hrs', $carResource);
        $this->assertArrayHasKey('discount', $carResource);
        $this->assertArrayHasKey('amount_spent', $carResource);
        $this->assertArrayHasKey('time_spent', $carResource);
    }
}
