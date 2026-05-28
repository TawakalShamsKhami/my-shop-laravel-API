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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->decimal('amount', 15, 2);
        $table->string('status');
        $table->string('transaction_reference')->nullable();
        $table->string('payment_method');
        $table->foreignId('order_id')->nullable()->constrained('orders');
        $table->foreignId('service_id')->nullable()->constrained('services');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
