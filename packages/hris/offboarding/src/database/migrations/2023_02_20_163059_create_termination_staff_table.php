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
        Schema::create('termination_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('termination_type')->index();
            $table->unsignedBigInteger('terminate_by')->index();
            $table->text('termination_detail', 1000);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('justification_detail')->nullable();
            $table->date('justification_date')->nullable();
            $table->string('status');
            $table->date('offBoarding_date')->nullable();
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
        Schema::dropIfExists('termination_staff');
    }
};
