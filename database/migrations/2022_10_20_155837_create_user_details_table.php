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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('tenure', 10,2)->nullable();
            $table->string('marital_status')->nullable();
            $table->string('work_mode')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->date('resigned_date')->nullable();
            $table->string('resigned_reason')->nullable();
            $table->string('assets_taken',500)->nullable();
            $table->string('blood_group',10)->nullable();
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
        Schema::dropIfExists('user_details');
    }
};
