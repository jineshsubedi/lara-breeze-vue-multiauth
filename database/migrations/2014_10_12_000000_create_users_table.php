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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->index();
            $table->string('father_name')->nullable();
            $table->string('employee_code',50)->nullable();
            $table->string('email',100)->unique();
            $table->string('password');
            $table->tinyInteger('staff_type')->comment('1 admin, 2 supervisor, 3 staffs');
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('department_id')->index();
            $table->unsignedBigInteger('designation_id')->index();
            $table->unsignedBigInteger('shift_time_id')->index();
            $table->unsignedBigInteger('supervisor_id')->index();
            $table->string('status')->comment('Enum Value in Enum file');
            $table->string('gender')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('salary_type')->nullable();
            $table->date('dob')->nullable();
            $table->date('join_date')->nullable();
            $table->date('provision_end_date')->nullable();
            $table->string('avatar')->nullable();
            $table->string('weekend')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
