<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_deposits', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('area_id')->nullable();

            $table->decimal('deposit_amount', 10, 2);
            $table->decimal('interest_rate', 10, 2); // % rate
            $table->integer('duration_months'); // FD duration

            $table->decimal('mature_amount', 10, 2);
            $table->date('mature_date');

            $table->enum('status', ['running', 'matured', 'withdrawn'])->default('running');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('fixed_deposits');
    }
}
