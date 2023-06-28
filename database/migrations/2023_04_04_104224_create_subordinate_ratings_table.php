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
        Schema::create('subordinate_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->comment("added by");
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->double('supervisory', 10,2);
            $table->double('leadership', 10,2);
            $table->double('quality', 10,2);
            $table->double('communication', 10,2);
            $table->double('consistency', 10,2);
            $table->double('independent', 10,2);
            $table->double('proactiveness', 10,2);
            $table->double('creativity', 10,2);
            $table->text('supervisory_detail')->nullable();
            $table->text('leadership_detail')->nullable();
            $table->text('quality_detail')->nullable();
            $table->text('communication_detail')->nullable();
            $table->text('consistency_detail')->nullable();
            $table->text('independent_detail')->nullable();
            $table->text('proactiveness_detail')->nullable();
            $table->text('creativity_detail')->nullable();
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
        Schema::dropIfExists('subordinate_ratings');
    }
};
