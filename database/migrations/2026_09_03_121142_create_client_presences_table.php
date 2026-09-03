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
        Schema::create('client_presences', function (Blueprint $table) {
            $table->id();
            $table->string('region_type'); // state (Brasil, por UF) ou country (fora do Brasil)
            $table->string('code'); // UF (ex.: MG, SP) ou código de país (ex.: MX, US)
            $table->string('name'); // nome de exibição (ex.: Minas Gerais, México)
            $table->unsignedInteger('device_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['region_type', 'code']);
            $table->index(['is_active', 'region_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_presences');
    }
};
