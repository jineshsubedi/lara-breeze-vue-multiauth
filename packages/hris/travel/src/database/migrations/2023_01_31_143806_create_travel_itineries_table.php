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
        Schema::create('travel_itineries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_planner_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->string('travel_from', 100);
            $table->string('travel_to', 100);
            $table->time('time_from');
            $table->time('time_to');
            $table->text('description', 3000);
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
        Schema::dropIfExists('travel_itineries');
    }
};
