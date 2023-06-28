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
        Schema::create('user_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('base_salary',10,2)->default(0);
            $table->decimal('basic_salary',10,2)->default(0);
            $table->decimal('ta',10,2)->default(0)->comment('Travel Allowance');
            $table->decimal('da',10,2)->default(0)->comment('Dearness Allowance');
            $table->decimal('ca',10,2)->default(0)->comment('Conveyance Allowance');
            $table->decimal('daily_al',10,2)->default(0)->comment('Daily Allowance');
            $table->decimal('fa',10,2)->default(0)->comment('Fuel Allowance');
            $table->decimal('ma',10,2)->default(0)->comment('Communication Allowance');
            $table->decimal('pa',10,2)->default(0)->comment('Project Allowance');
            $table->decimal('incentive',10,2)->default(0);
            $table->enum('pf',[1,2])->default(1)->commet('1 => Yes, 2 => No');
            $table->enum('ot',[1,2])->default(1)->commet('1 => Yes, 2 => No');
            $table->decimal('cit',10,2)->default(0);
            $table->decimal('insurance',10,2)->default(0);
            $table->decimal('petty_cass',10,2)->default(0);
            $table->decimal('advance',10,2)->default(0);
            $table->decimal('others',10,2)->default(0);
            $table->decimal('total_salary',10,2)->default(0);
            $table->date('salary_date')->nullable();
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
        Schema::dropIfExists('user_salaries');
    }
};
