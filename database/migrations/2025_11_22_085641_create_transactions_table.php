<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->nullable();
            $table->foreignId('member_id')->constrained()->cascadeOnUpdate()->nullable();
            $table->decimal('join_fee', 20, 2)->nullable();
            $table->decimal('service_charge', 20, 2)->nullable();
            $table->decimal('late_service_charge', 20, 2)->nullable();
            $table->tinyInteger('status')->default('1')->comment('1=Active,0=InActive');
            $table->enum('type', ['admin', 'member']);
            $table->enum('transaction_type', ['debit', 'credit']);
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
        Schema::dropIfExists('transactions');
    }
}
