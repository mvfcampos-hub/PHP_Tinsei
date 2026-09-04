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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // "image": banner clássico com imagem enviada pelo admin.
            // "product_spotlight": slide desenhado em CSS a partir dos dados
            // reais de um produto (ícone, tagline, resumo e destaques), sem
            // depender de uma peça gráfica pronta.
            $table->string('variant')->default('image');
            $table->string('image')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->json('highlights')->nullable();
            $table->string('link_url')->nullable();
            $table->string('placement')->default('home_hero');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('overlay_title')->default(true);
            $table->timestamps();

            $table->index(['placement', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
