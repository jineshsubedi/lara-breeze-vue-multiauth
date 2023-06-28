<?php

use Hris\Offboarding\Enums\TerminationStatus;
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
        Schema::create('resignation_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('resignation_type_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('resignation_reason_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('resignation_detail');
            $table->date('resignation_date');
            $table->integer('supervisor')->nullable();
            $table->date('supervisor_approval_date')->nullable();
            $table->text('supervisor_approval_detail')->nullable();
            $table->string('supervisor_approval_status')->default('pending');
            $table->string('status')->default('pending');
            $table->integer('approval_by')->nullable();
            $table->text('approval_detail')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('offBoarding_date')->nullable();
            $table->tinyInteger('retract')->default(0);
            $table->string('settlement_letter')->nullable();
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
        Schema::dropIfExists('resignation_staff');
    }
};
