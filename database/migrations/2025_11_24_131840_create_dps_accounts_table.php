<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dps_accounts', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('plan_id');
            $table->decimal('monthly_deposit', 10, 2);
            $table->integer('duration_months');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('total_deposit', 10, 2)->default(0);
            $table->decimal('mature_amount', 10, 2)->default(0);
            $table->date('mature_date')->nullable();
            $table->enum('status', ['running', 'matured', 'closed'])->default('running');
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
        Schema::dropIfExists('dps_accounts');
    }
}
