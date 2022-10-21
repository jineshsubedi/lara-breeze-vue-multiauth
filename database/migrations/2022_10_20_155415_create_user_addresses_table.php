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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('pdistrict_id')->default(0)->index();
            $table->unsignedBigInteger('tdistrict_id')->default(0)->index();
            $table->string('p_address')->nullable();
            $table->string('t_address')->nullable();
            $table->string('emergency_number',20)->nullable();
            $table->string('primary_location',50)->nullable();
            $table->string('contact_person',20)->nullable();
            $table->string('contact_person_number',20)->nullable();
            $table->string('home_location',50)->nullable();
            $table->string('phone_number',50)->nullable();
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
        Schema::dropIfExists('user_addresses');
    }
};
