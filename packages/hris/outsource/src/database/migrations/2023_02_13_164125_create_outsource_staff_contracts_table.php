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
        Schema::create('outsource_staff_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outsource_staff_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('contract_start');
            $table->date('contract_end');
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
            $table->tinyInteger('current')->default(0);
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
        Schema::dropIfExists('outsource_staff_contracts');
    }
};
