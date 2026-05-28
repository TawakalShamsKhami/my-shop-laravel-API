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
        // Change 'table' to 'create' to actually build the table
        Schema::create('company_ownership_types', function (Blueprint $table) {
            $table->id();
            
            // Define the columns first
            $table->unsignedBigInteger('owner_ship_type_id');
            $table->unsignedBigInteger('company_id');
            
            $table->timestamps();

            // Then define the foreign key constraints
            $table->foreign('owner_ship_type_id')
                ->references('id')
                ->on('ownership_types')
                ->onDelete('cascade');

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_ownership_types');
    }
};