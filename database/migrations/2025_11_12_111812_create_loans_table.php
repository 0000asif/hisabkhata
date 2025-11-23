<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('area_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('member_id')->constrained()->cascadeOnUpdate();
            $table->decimal('loan_amount', 40, 2)->nullable();
            $table->enum('interest_type', ['percent', 'flat']);
            $table->decimal('interest', 40, 2)->nullable();
            $table->decimal('total_amount', 40, 2)->nullable();
            $table->enum('installment_type', ['daily', 'weekly', 'fortnightly', 'monthly', '6month']);
            $table->integer('loan_count');
            $table->decimal('single_loan_amount', 40, 2);
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
        Schema::dropIfExists('loans');
    }
}
