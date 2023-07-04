<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiscountCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('discount_cards')) {
            DB::table('discount_cards')->insert(
                [
                    ['id'=>1,'name'=>'silver','discount'=>10],
                    ['id'=>2,'name'=>'gold','discount'=>15],
                    ['id'=>3,'name'=>'platinum','discount'=>20]
                ]
            );
        }
    }
}
