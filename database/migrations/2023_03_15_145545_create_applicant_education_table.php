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
        Schema::create('applicant_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('applicant_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('country')->nullable();
            $table->unsignedBigInteger('educationlevel_id')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->string('status')->nullable();
            $table->string('specialization')->nullable();
            $table->string('institution')->nullable();
            $table->string('board')->nullable();
            $table->decimal('percentage', 10, 2)->nullable();
            $table->string('marksystem')->nullable();
            $table->string('year')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('applicant_education');
    }
};
