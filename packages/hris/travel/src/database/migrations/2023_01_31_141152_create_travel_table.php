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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('unique_id', 255)->collation('utf8_unicode_ci');
            $table->unsignedBigInteger('assigned_to')->index();
            $table->enum('type', ['domestic', 'international'])->collation('utf8_unicode_ci');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->unsignedBigInteger('assigned_from')->index();
            $table->string('purpose', 255)->collation('utf8_unicode_ci');
            $table->enum('mode_of_transport', ['road', 'air', 'water'])->collation('utf8_unicode_ci');
            $table->integer('assignment_type');
            $table->integer('assignment_category');
            $table->integer('payment_mode');
            $table->integer('road_sub')->nullable();
            $table->integer('reimbursement')->nullable();
            $table->integer('position')->nullable();
            $table->integer('grade')->nullable();
            $table->double('per_diem_amount', 15,2)->nullable();
            $table->string('account_number', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('account_name', 255)->collation('utf8_unicode_ci')->nullable();
            $table->string('bank_name', 255)->collation('utf8_unicode_ci')->nullable();
            $table->tinyInteger('advance_required')->default(0);
            $table->tinyInteger('accept_status')->default(0);
            $table->integer('supervisor_approval')->default(0);
            $table->string('supervisor_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('account_approval')->default(0);
            $table->string('account_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('hr_approval')->default(0);
            $table->string('hr_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('chairman_approval')->default(0);
            $table->string('chairman_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('supervisor_expense_approval')->default(0);
            $table->string('supervisor_expense_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('account_expense_approval')->default(0);
            $table->string('account_expense_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('hr_expense_approval')->default(0);
            $table->string('hr_expense_remark', 255)->collation('utf8_unicode_ci')->nullable();
            $table->integer('chairman_expense_approval')->default(0);
            $table->string('chairman_expense_remark', 255)->collation('utf8_unicode_ci')->nullable();
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
        Schema::dropIfExists('travel');
    }
};
