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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('teleorder_date');
            $table->string('teleorder_no');
            $table->foreignId('code_id')->references('id')->on('codes');
            $table->longText('po_no');
            $table->date('delivery_date');
            $table->date('order_date');
            $table->string('paymentTerms');
            $table->string('deliveredBy');
            $table->longText('deliveredTo');
            $table->longText('specialInstruction');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
