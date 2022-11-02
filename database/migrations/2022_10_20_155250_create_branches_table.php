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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name',80)->unique();
            $table->string('email',80)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('province_id')->index();
            $table->unsignedBigInteger('district_id')->index();
            $table->boolean('is_head')->default(0)->comment('1 => head, 0 => normal');
            $table->string('login_ip')->nullable();
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
        Schema::dropIfExists('branches');
    }
};
