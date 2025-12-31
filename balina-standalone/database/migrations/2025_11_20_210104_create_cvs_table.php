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
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // CV Başlığı (Örn: Yazılım Mühendisi)
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('summary')->nullable();
            $table->json('education')->nullable(); // Okul, Bölüm, Tarih
            $table->json('experience')->nullable(); // Şirket, Pozisyon, Tarih, Açıklama
            $table->json('skills')->nullable(); // Yetenekler listesi
            $table->json('languages')->nullable(); // Diller ve seviyeleri
            $table->json('social_links')->nullable(); // LinkedIn, GitHub vb.
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
