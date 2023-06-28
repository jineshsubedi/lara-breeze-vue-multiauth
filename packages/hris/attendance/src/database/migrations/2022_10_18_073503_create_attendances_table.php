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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('branch_id')->default(0);
            $table->date('attendance_date');
            $table->time('in_time');
            $table->time('out_time')->nullable();
            $table->time('lunch_start')->nullable();
            $table->time('lunch_end')->nullable();
            $table->string('in_location',50)->nullable();
            $table->string('out_location',50)->nullable();
            $table->string('lunch_start_location',50)->nullable();
            $table->string('lunch_end_location',50)->nullable();
            $table->integer('np_year')->nullable();
            $table->integer('np_month')->nullable();
            $table->integer('np_date')->nullable();
            $table->enum('approve', [0,1])->default(0);
            $table->enum('manual', [0,1])->default(0);
            $table->string('in_time_reason')->nullable();
            $table->string('out_time_reason')->nullable();
            $table->string('in_away_location')->nullable();
            $table->string('out_away_location')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('attendances');
    }
};
