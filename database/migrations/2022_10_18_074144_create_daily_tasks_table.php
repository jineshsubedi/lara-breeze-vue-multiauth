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
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('en_year')->nullable();
            $table->integer('np_year')->nullable();
            $table->integer('np_month')->nullable();
            $table->integer('np_day')->nullable();
            $table->integer('en_month')->nullable();
            $table->integer('en_day')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('kra_id')->default(0)->index();
            $table->unsignedBigInteger('task_id')->default(0)->index();
            $table->enum('status', [0,1])->default(0)->comment('0 => not approved, 1 => approved');
            $table->decimal('duration', 10,2)->default(0);
            $table->decimal('estimated_duration', 10,2)->default(0);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('daily_tasks');
    }
};
