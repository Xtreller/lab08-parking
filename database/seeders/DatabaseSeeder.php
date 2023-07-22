<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CarTypesSeeder::class;
        DiscountCarsSeeder::class;
        InitialDataSeeder::class;
        // \App\Models\User::factory(10)->create();
    }
}
