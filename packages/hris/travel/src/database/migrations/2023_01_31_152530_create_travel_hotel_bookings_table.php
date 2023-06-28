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
        Schema::create('travel_hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_planner_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('place_name')->nullable();
            $table->string('district')->nullable();
            $table->string('number')->nullable();
            $table->string('remark')->nullable();
            $table->date('arrival_at');
            $table->date('departure_at');
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
        Schema::dropIfExists('travel_hotel_bookings');
    }
};
