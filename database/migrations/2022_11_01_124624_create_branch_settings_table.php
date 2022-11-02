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
        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('attendance_handler')->default(0);
            $table->integer('account_handler')->default(0);
            $table->integer('hr_handler')->default(0);
            $table->integer('staff_handler')->default(0);
            $table->integer('survey_handler')->default(0);
            $table->integer('training_handler')->default(0);
            $table->integer('salary_calculate')->default(0);
            $table->integer('revenue')->default(0);
            $table->integer('client')->default(0);
            $table->integer('canteen')->default(0);
            $table->integer('performance_rater')->default(0);
            $table->integer('client_comment')->default(0);
            $table->integer('comment_type')->default(0);
            $table->integer('performance_rating_type')->default(0);
            $table->string('account_handler_signature')->nullable();
            $table->string('out_source_handler')->nullable();
            $table->boolean('performance_rating')->default(0)->comment('1 => Yes, 0 => No');
            $table->integer('rating_time')->nullable();
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
        Schema::dropIfExists('branch_settings');
    }
};
