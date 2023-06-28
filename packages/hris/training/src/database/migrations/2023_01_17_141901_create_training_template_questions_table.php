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
        Schema::create('training_template_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_template_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('question');
            $table->string('type', 50);
            $table->string('list_menu', 200);
            $table->boolean('mandatory')->default(true);
            $table->tinyInteger('order');
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
        Schema::dropIfExists('training_template_questions');
    }
};
