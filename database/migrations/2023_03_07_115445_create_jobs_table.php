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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('location_title');
            $table->integer('job_level')->nullable();
            $table->string('job_availability');
            $table->date('deadline');
            $table->integer('min_experience')->nullable();
            $table->integer('education_level')->nullable();
            $table->integer('faculty')->nullable();
            $table->integer('position')->nullable();
            $table->string('vacancy_code', 255);
            $table->string('external_link', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('salary_unit', 255)->nullable();
            $table->integer('negotiable')->default(0);
            $table->string('minimum_salary', 100)->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('seo_url', 255)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('publish_date')->nullable();
            $table->string('assignment_handeler', 255)->nullable();
            $table->string('line_manager', 255)->nullable();
            $table->integer('process_status')->default(0);
            $table->integer('setting')->default(0);
            $table->integer('apply_type')->nullable();
            $table->string('emails', 255)->nullable();
            $table->integer('trash')->default(0);
            $table->text('formfields')->nullable();
            $table->text('education_levels')->nullable();
            $table->integer('emanual')->default(0);
            $table->string('job_file', 255)->nullable();
            $table->string('advertise_link', 1000)->nullable();
            $table->string('advertise_detail', 500)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('edu_marks', 11)->nullable();
            $table->string('exp_marks', 11)->nullable();
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('jobs');
    }
};
