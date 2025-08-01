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
        Schema::create('rejecteds', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->double('credit_limit');
            $table->double('cl_balance');
            $table->longText('order_taken_by');
            $table->foreignId('transaction_id')->nullable()->references('id')->on('transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejecteds');
    }
};
