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
        Schema::create('job_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('education_description')->nullable();
            $table->longText('specific_requirement')->nullable();
            $table->longText('specific_instruction')->nullable();
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
        Schema::dropIfExists('job_requirements');
    }
};
