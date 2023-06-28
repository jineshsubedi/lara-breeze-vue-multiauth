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
        Schema::create('temporary_job_forms', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('f_lable')->nullable();
            $table->string('f_type')->nullable();
            $table->string('list_menu')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('parent_id')->nullable();
            $table->string('marks')->nullable();
            $table->string('extra')->nullable();
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
        Schema::dropIfExists('temporary_job_forms');
    }
};
