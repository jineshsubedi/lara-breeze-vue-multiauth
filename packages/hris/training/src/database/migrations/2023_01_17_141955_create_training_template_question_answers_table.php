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
        Schema::create('training_template_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('training_template_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedBigInteger('staff_id')->default(0)->index();
            $table->string('question');
            $table->string('answer');
            $table->string('type');
            $table->double('score',10,2);
            $table->date('answer_date');
            $table->boolean('is_trainer')->default(0);
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
        Schema::dropIfExists('training_template_question_answers');
    }
};
