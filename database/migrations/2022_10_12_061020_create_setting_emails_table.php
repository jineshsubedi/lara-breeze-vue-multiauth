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
        Schema::create('setting_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id');
            $table->string('protocal');
            $table->string('parameter');
            $table->string('host_name');
            $table->string('username');
            $table->string('password');
            $table->string('smtp_port');
            $table->string('encryption');
            $table->timestamps();

            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->index(['setting_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_emails');
    }
};
