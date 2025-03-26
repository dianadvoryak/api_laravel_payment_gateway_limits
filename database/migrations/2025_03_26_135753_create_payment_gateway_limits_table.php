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
        Schema::create('payment_gateway_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gateway_id')->constrained('payment'); 
            $table->decimal('limit'); 
            $table->decimal('used_amount')->default(0); 
            $table->timestamp('reset_at')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_limits');
    }
};
