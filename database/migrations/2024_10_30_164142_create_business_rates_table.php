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
        Schema::create('business_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('business_details')->onDelete('cascade');
            $table->integer('distance_from');
            $table->integer('distance_to');
            $table->decimal('rate', 8, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_rates');
    }
};
