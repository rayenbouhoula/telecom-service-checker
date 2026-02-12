<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coverage_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->json('coverage_data');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
            
            $table->index(['area_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_history');
    }
};
