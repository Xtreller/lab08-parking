<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarType;
use App\Models\Parking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParkingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_return_free_spaces()
    {
        Parking::factory()->create();
        $this->get('/api/lab08/free_spaces')
            ->assertJson(['data' => ['free_spaces' => 200]])
            ->assertOk();
    }
    public function test_car_enters_validation_no_space()
    {
        $parking = Parking::factory()->create(['free_spaces' => 1]);
        $car_type = CarType::factory()->create(['space_needed' => 3]);
        $car = Car::factory()->create(['type' => $car_type->id]);
        $data = ['registration' => $car->registration];
        $this->post('/api/lab08/car_enters', $data)
            ->assertStatus(422)
            ->assertJson(['message' => 'Няма свободни места!', 'status' => 'fail']);

    }
    public function test_car_enters_validation_already_parked()
    {
        $parking = Parking::factory()->create();
        $car_type = CarType::factory()->create(['space_needed' => 3]);
        $car = Car::factory()->create(['type' => $car_type->id]);
        $data = ['registration' => $car->registration];
        $this->post('/api/lab08/car_enters', $data)
            ->assertJson(['data' => ['free_spaces' => $parking->free_spaces - $car_type->space_needed]])
            ->assertOk();
        $this->post('/api/lab08/car_enters', $data)
            ->assertStatus(422)
            ->assertJson(['message' => 'Кола с рег.номер ' . $car->registration . ' вече е паркирана!', 'status' => 'fail']);


    }
    public function test_car_enters()
    {
        $parking = Parking::factory()->create();
        $car_type = CarType::factory()->create();
        $car = Car::factory()->create(['type' => $car_type->id]);
        $data = ['registration' => $car->registration];
        $this->post('/api/lab08/car_enters', $data)
            ->assertJson(['data' => ['free_spaces' => $parking->free_spaces - $car_type->space_needed]])
            ->assertOk();
    }

    public function test_car_exits()
    {
        $parking = Parking::factory()->create();
        $car_type = CarType::factory()->create(['space_needed' => 3]);
        $car = Car::factory()->create(['type' => $car_type->id]);
        $data = ['registration' => $car->registration];

        $this->post('/api/lab08/car_enters', $data)
            ->assertJson(['data' => ['free_spaces' => $parking->free_spaces - $car_type->space_needed]])
            ->assertOk();

        $this->post('/api/lab08/car_exits', $data)
            ->assertJson(['data' => ['free_spaces' => $parking->free_spaces]])
            ->assertOk();

    }
    public function test_car_exits_validation_not_parked()
    {
        $parking = Parking::factory()->create();
        $car_type = CarType::factory()->create(['space_needed' => 3]);
        $car = Car::factory()->create(['type' => $car_type->id]);
        $data = ['registration' => $car->registration];

        $this->post('/api/lab08/car_exits', $data)
            ->assertStatus(422)
            ->assertJson(['message' => 'Кола с рег.номер ' . $car->registration . ' не е паркирана!', 'status' => 'fail']);


    }
    public function test_car_exits_validation_not_found()
    {
        $parking = Parking::factory()->create();

        $data = ['registration' => 'randomnum'];

        $this->post('/api/lab08/car_exits', $data)
            ->assertStatus(404);
    }

}
