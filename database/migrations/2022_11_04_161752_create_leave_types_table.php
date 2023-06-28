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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title')->unique();
            $table->tinyInteger('days');
            $table->tinyInteger('eligible')->comment('This is for eligible after X month');
            $table->tinyInteger('continuous')->comment('This is for continuous leave X days');
            $table->tinyInteger('apply_before')->comment('This is for apply before X days');
            $table->tinyInteger('accrual')->comment('This is for apply before X days');
            $table->boolean('accrual_basis')->default(0)->comment('1 => yes, 0 => No (Management Approval)');
            $table->tinyInteger('is_extra')->nullable()->comment('1 => file, 0 => date');
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
        Schema::dropIfExists('leave_types');
    }
};
