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
        Schema::create('job_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobs_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->index();
            $table->string('f_lable')->nullable();
            $table->string('f_type')->nullable();
            $table->string('list_menu')->nullable();
            $table->boolean('required')->default(false);
            $table->string('marks')->nullable();
            $table->string('extra')->nullable();
            $table->string('extra_type')->nullable();
            $table->string('fe_lable')->nullable();
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
        Schema::dropIfExists('job_forms');
    }
};
