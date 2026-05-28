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
        Schema::create('stock_registrations', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('status')->default('active');
        $table->integer('quantities_registrar');
        $table->integer('quantities_remain');
        $table->decimal('buying_price', 15, 2);
        $table->decimal('selling_price', 15, 2);
        $table->string('stock_identification_code');
        $table->integer('stock_squence')->nullable();
        $table->foreignId('stock_definition_id')->constrained('stock_definitions');
        $table->foreignId('unit_id')->constrained('units');
        $table->string('created_by');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_registrations');
    }
};
