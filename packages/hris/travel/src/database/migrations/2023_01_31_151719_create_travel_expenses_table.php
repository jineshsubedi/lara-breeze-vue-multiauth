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
        Schema::create('travel_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('type')->nullable();
            $table->integer('destination_id')->nullable();
            $table->decimal('ticket', 8, 2)->default(0.00);
            $table->decimal('lodging', 8, 2)->default(0.00);
            $table->decimal('breakfast', 8, 2)->default(0.00);
            $table->decimal('lunch', 8, 2)->default(0.00);
            $table->decimal('dinner', 8, 2)->default(0.00);
            $table->decimal('phone', 8, 2)->default(0.00);
            $table->decimal('local_conveyance', 8, 2)->default(0.00);
            $table->decimal('others', 8, 2)->default(0.00);
            $table->decimal('total', 15, 2)->nullable();
            $table->text('description')->collation('utf8_unicode_ci');
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
        Schema::dropIfExists('travel_expenses');
    }
};
