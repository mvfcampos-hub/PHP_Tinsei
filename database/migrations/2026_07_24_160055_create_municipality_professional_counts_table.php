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
        Schema::create('municipality_professional_counts', function (Blueprint $table) {
            $table->id();
            $table->string('municipality');
            $table->string('state', 2)->default('MG');
            $table->string('category')->nullable();
            $table->unsignedInteger('professionals_count')->default(0);
            $table->date('reference_date')->nullable();
            $table->timestamps();

            $table->unique(['municipality', 'state', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipality_professional_counts');
    }
};
