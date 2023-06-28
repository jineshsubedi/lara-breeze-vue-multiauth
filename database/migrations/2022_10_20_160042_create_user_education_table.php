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
        Schema::create('user_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('education_level_id')->index();
            $table->unsignedBigInteger('faculty_id')->index();
            $table->string('specialization',80)->nullable();
            $table->string('institution',80)->nullable();
            $table->string('year',10)->nullable();
            $table->string('board',80)->nullable();
            $table->enum('marksystem',['percentage','gpa'])->nullable();
            $table->string('mark',80)->nullable();
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
        Schema::dropIfExists('user_education');
    }
};
