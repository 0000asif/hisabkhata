<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')
                ->constrained()
                ->cascadeOnUpdate();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnUpdate();

            $table->date('due_date');
            $table->decimal('amount', 40, 2);
            $table->decimal('paid_amount', 40, 2)->default(0);
            $table->decimal('remaining_amount', 40, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'partial'])->default('pending');
            $table->date('paid_date')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->string('note')->nullable();

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
        Schema::dropIfExists('installments');
    }
}
