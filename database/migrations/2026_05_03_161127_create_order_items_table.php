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
        Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->integer('quantities_sold');
        $table->string('sales_identification_code');
        $table->string('status');
        $table->decimal('price', 15, 2);
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('stock_registration_id')->constrained('stock_registrations');
        $table->foreignId('tax_id')->constrained('taxes');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
