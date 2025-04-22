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
        Schema::create('book_drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_test_id');
            $table->string('fullname');
            $table->string('phone');
            $table->date('date_drive');
            $table->time('time_drive');
            $table->string('note')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_drivers');
    }
};
