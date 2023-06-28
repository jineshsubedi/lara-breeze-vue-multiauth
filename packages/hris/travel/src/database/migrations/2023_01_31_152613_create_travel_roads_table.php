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
        Schema::create('travel_roads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_planner_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('vehicle_number')->nullable();
            $table->string('driver_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('bus_number')->nullable();
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
        Schema::dropIfExists('travel_roads');
    }
};
