<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //assuming there may be more car types in future, destructing existing ones
        Schema::create('car_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('space_needed');
            $table->decimal('night_price');
            $table->decimal('day_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_types');
    }
};
