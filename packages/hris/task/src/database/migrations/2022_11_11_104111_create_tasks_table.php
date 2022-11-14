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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('parent_type')->default(0)->comment('1 will be assign task 2 for assign job');
            $table->bigInteger('parent_id')->default(0)->index();
            $table->unsignedBigInteger('task_from')->index();
            $table->foreign('task_from')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('task_to')->index();
            $table->foreign('task_to')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('description',500)->nullable();
            $table->enum('complete_status',[0,1])->default(0)->comment('0 => not complete, 1 => completed');
            $table->date('accept_date')->nullable();
            $table->date('complete_date')->nullable();
            $table->date('start_time')->nullable();
            $table->date('finish_time')->nullable();
            $table->string('remarks')->nullable();
            $table->string('s_remarks')->nullable()->comment('supervisor remarks');
            $table->tinyInteger('priority')->default(0);
            $table->decimal('self_mark',5,2)->default(0);
            $table->decimal('supervisor_mark',5,2)->default(0);
            $table->integer('num_task')->default(0);
            $table->unsignedBigInteger('kra_id')->default(0)->index();
            $table->string('project')->nullable();
            $table->enum('personal', [0,1])->default(0)->comment('1 for private');
            $table->decimal('weightage',5,2)->default(1);
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
        Schema::dropIfExists('tasks');
    }
};
