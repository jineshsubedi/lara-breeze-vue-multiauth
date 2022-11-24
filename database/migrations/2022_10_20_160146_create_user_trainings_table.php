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
        Schema::create('user_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title',80)->nullable();
            $table->longText('details')->nullable();
            $table->string('institution',80)->nullable();
            $table->string('duration',80)->nullable();
            $table->string('year',10)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
           
            $table->foreignId('user_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('user_trainings');
    }
};
