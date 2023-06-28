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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('email');
            $table->string('citizenship')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('image')->nullable();
            $table->string('resume')->nullable();
            $table->string('cover_letter')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('temporary_address')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('license_of')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('apply_date');
            $table->string('validation_token')->nullable();
            $table->double('age',10,2)->nullable(0);
            $table->double('total_experience',10,2)->default(0);
            $table->string('tracking_code')->nullable();
            $table->string('district')->nullable();
            $table->string('municipality')->nullable();
            $table->string('ward')->nullable();
            $table->tinyInteger('trash')->default(0);
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
        Schema::dropIfExists('applicants');
    }
};
