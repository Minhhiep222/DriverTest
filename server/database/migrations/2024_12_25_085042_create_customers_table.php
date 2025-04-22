<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('fullname')->nullable();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('area')->nullable();
            $table->string('email')->nullable();
            $table->string('img')->nullable();
            $table->string('hobbit')->nullable();
            $table->integer('income')->nullable(); //Thu nhập
            $table->integer('members')->nullable(); //Số lượng thành viên gia đình
            $table->integer('age')->nullable();
            $table->enum('owned', ['yes', 'no'])->nullable(); //Đã từng sở hữu xe
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->enum('type', ['normal', 'vip'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
