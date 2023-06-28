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
        Schema::create('on_board_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('department_id')->index();
            $table->unsignedBigInteger('designation_id')->index();
            $table->unsignedBigInteger('supervisor_id')->index();
            $table->string('name');
            $table->string('email');
            $table->tinyInteger('staff_type')->comment('1 admin, 2 supervisor, 3 staffs');
            $table->string('nature_of_job')->nullable();
            $table->string('nature_of_employment')->nullable();
            $table->decimal('salary', 15, 2)->default(0.00);
            $table->boolean('trail_period')->default(false);
            $table->unsignedInteger('no_of_days')->nullable();
            $table->date('trail_start_date')->nullable();
            $table->date('joining_date');
            $table->string('offer_letter')->nullable();
            $table->date('letter_accept_date')->nullable();
            $table->string('cv')->nullable();
            $table->string('level')->nullable();
            $table->string('supervisor_approval',100)->nullable();
            $table->text('supervisor_comment',500)->nullable();
            $table->date('supervisor_approval_date')->nullable();
            $table->string('hr_approval',100)->nullable();
            $table->text('hr_comment',500)->nullable();
            $table->date('hr_approval_date')->nullable();
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
        Schema::dropIfExists('on_board_staff');
    }
};
