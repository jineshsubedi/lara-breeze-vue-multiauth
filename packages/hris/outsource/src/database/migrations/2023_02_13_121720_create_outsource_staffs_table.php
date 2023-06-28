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
        Schema::create('outsource_staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outsource_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('staff_code');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('temporary_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('sex')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('education')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('ssf_number')->nullable();
            $table->string('account_name')->nullable();
            $table->date('join_date')->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('status');
            $table->string('account_number')->nullable();
            $table->string('cit_number')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('emergency_other_number')->nullable();
            $table->text('documents')->nullable();
            $table->text('asset_taken')->nullable();
            $table->text('medical')->nullable();
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
        Schema::dropIfExists('outsource_staffs');
    }
};
