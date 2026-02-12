<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coverage_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->json('coverage_data');
            $table->string('user_ip')->nullable();
            $table->timestamps();
            
            $table->index(['area_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_checks');
    }
};
