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
        Schema::create('applicant_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('applicant_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('language')->nullable();
            $table->string('understand')->nullable();
            $table->string('speak')->nullable();
            $table->string('reading')->nullable();
            $table->string('writing')->nullable();
            $table->string('mother_t')->nullable();
            $table->tinyInteger('sn')->nullable();
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
        Schema::dropIfExists('applicant_languages');
    }
};
