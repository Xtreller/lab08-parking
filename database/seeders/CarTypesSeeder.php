<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CarTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('car_types')) {
            DB::table('car_types')->insert(
                [
                    ['id'=>1,'name'=>'car/motorcycle','space_needed'=>1,'night_price'=>2,'day_price'=>3],
                    ['id'=>2,'name'=>'van','space_needed'=>2,'night_price'=>4,'day_price'=>6],
                    ['id'=>3,'name'=>'bus/lorry','space_needed'=>3,'night_price'=>8,'day_price'=>12],
                ]
            );
        }
    }
}
