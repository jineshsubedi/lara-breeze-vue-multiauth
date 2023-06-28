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
        Schema::create('applicant_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('applicant_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('organization', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->string('level', 255)->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('currently_working', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('duties', 255)->nullable();
            $table->string('document', 255)->nullable();
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
        Schema::dropIfExists('applicant_experiences');
    }
};
