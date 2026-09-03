<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('msp_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('server_price', 10, 2)->default(250);
            $table->decimal('minimum_contract', 10, 2)->default(1390);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('msp_settings');
    }
};
