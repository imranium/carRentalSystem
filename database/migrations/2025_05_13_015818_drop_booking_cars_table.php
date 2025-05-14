<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBookingCarsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('booking__cars');
    }

    public function down()
    {
        // Optional: recreate if rollback is needed
        Schema::create('booking_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
}

