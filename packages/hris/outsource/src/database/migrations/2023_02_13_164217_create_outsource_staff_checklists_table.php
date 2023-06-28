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
        Schema::create('outsource_staff_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outsource_staff_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('group_medical_insurance')->nullable();
            $table->string('group_accidental_insurance')->nullable();
            $table->string('assets')->nullable();
            $table->string('id_card')->nullable();
            $table->string('experience_letter')->nullable();
            $table->string('salary_settlement')->nullable();
            $table->string('warning_letter')->nullable();
            $table->string('pending_work')->nullable();
            $table->string('advance_payment')->nullable();
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
        Schema::dropIfExists('outsource_staff_checklists');
    }
};
