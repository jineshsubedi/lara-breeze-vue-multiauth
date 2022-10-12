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
        Schema::create('setting_socials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id');
            $table->string('name');
            $table->string('icon');
            $table->string('url');
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
        Schema::dropIfExists('setting_socials');
    }
};
