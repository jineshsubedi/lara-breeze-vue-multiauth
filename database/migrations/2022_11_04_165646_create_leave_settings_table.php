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
        Schema::create('leave_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('quarter_day')->default(0)->comment('1 => allow, 0 => disallow');
            $table->boolean('half_day')->default(1)->comment('1 => allow, 0 => disallow');
            $table->boolean('sandwich')->default(0)->comment('1 => allow, 0 => disallow (sandwich means skip holiday and weekend)');
            $table->boolean('handover')->default(0)->comment('1 => Required, 0 => Not Required');
            $table->boolean('s_approval')->default(0)->comment('1 => Required, 0 => Not Required (Supervisor Approval)');
            $table->boolean('h_approval')->default(0)->comment('1 => Required, 0 => Not Required (HR Approval)');
            $table->boolean('m_approval')->default(0)->comment('1 => Required, 0 => Not Required (Management Approval)');
            $table->boolean('accrual_basis')->default(0)->comment('1 => yes, 0 => No (Management Approval)');
            $table->bigInteger('hr_person')->default(0)->comment('hr person from user');
            $table->bigInteger('m_person')->default(0)->comment('management person from user');
            $table->bigInteger('leave_handler')->default(0);
            $table->bigInteger('maximum_leave')->default(0)->comment('Monthly maximum leave');
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
        Schema::dropIfExists('leave_settings');
    }
};
