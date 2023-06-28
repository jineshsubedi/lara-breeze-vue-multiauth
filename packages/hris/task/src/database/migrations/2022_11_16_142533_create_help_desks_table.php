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
        Schema::create('help_desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('task_from')->index();
            $table->foreign('task_from')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('task_to')->index();
            $table->foreign('task_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('kra_id')->default(0)->index();
            $table->string('title');
            $table->string('description',500)->nullable();
            $table->enum('accept_status', [0,1])->default(0)->comment('1 for Yes');
            $table->enum('complete_status', [0,1])->default(0)->comment('1 for Yes');
            $table->tinyInteger('priority')->default(0);
            $table->date('start_time')->nullable();
            $table->date('finish_time')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('task_id')->default(0)->index();
            $table->bigInteger('parent_id')->default(0)->index();
            $table->bigInteger('job_id')->default(0)->index();
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
        Schema::dropIfExists('help_desks');
    }
};
