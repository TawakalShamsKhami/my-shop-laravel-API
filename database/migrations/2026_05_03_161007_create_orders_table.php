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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('status');
        $table->foreignId('customer_id')->constrained('customers');
        $table->foreignId('sale_method_id')->constrained('sale_methods');
        $table->foreignId('staff_id')->constrained('staff');
        $table->string('created_by');

        // $table->foreignId('created_by')->constrained('users');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
