<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('area_id')->constrained()->cascadeOnUpdate();
            $table->foreignId('branch_id')->constrained()->cascadeOnUpdate();

            $table->date('joined_date')->nullable();

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->string('nid')->unique();
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();

            $table->string('father_name')->nullable();
            $table->string('guarantor')->nullable();

            $table->string('nominee')->nullable();
            $table->string('nominee_phone')->nullable();
            $table->string('nominee_relation')->nullable();

            $table->string('member_photo')->nullable();
            $table->string('nominee_photo')->nullable();
            $table->string('signature')->nullable();

            $table->string('password')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Inactive');

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
        Schema::dropIfExists('members');
    }
}
