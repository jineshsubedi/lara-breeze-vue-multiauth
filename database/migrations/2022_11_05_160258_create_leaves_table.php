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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('leave_type_id')->index();
            $table->tinyInteger('type')->default(1)->comment('1 => full day,2 => half day, 3 => quarter day');
            $table->date('compensation')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('duration')->nullable();
            $table->string('description')->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->enum('s_approve', ['0','1'])->default(0);
            $table->enum('h_approve', ['0','1'])->default(0);
            $table->enum('m_approve', ['0','1'])->default(0);
            $table->string('s_remarks')->nullable();
            $table->string('h_remarks')->nullable();
            $table->string('m_remarks')->nullable();
            $table->enum('paid', ['0','1'])->default(0)->comment('0 => paid, 1 => unpaid');
            $table->enum('emergency', ['0','1'])->default(0)->comment('0 => No, 1 => Yes');
            $table->string('document')->nullable();
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
        Schema::dropIfExists('leaves');
    }
};
