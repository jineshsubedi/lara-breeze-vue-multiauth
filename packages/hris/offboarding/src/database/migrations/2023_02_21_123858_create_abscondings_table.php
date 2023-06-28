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
        Schema::create('abscondings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('issued_by')->index();
            $table->date('issued_date');
            $table->tinyInteger('action')->default(0);
            $table->tinyInteger('previous_action')->default(0);
            $table->text('description', 1000);
            $table->boolean('suspension')->default(false);
            $table->boolean('penalty')->default(false);
            $table->integer('suspension_days')->nullable();
            $table->decimal('penalty_charge', 8, 2)->nullable();
            $table->tinyInteger('follow_up_medium')->nullable();
            $table->text('follow_up_description', 1000)->nullable();
            $table->string('follow_up_attachment')->nullable();
            $table->tinyInteger('termination')->default(0)->comment('1 for termination, 2 for hold');
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
        Schema::dropIfExists('abscondings');
    }
};
