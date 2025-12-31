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
        // Kategoriler tablosu (Mikroişlemciler, Otomata, Evrimsel Hesaplama, vb.)
        Schema::create('study_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Mikroişlemciler, Otomata, vb.
            $table->string('slug')->unique(); // mikroislemciler, otomata
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // emoji veya icon class
            $table->integer('order')->default(0); // Sıralama
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Çalışma notları tablosu
        Schema::create('study_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('study_categories')->onDelete('cascade');
            $table->string('title'); // Modül 1: Giriş
            $table->string('slug'); // modul1-giris
            $table->text('description')->nullable();
            $table->string('file_path'); // notes/mikroislemciler/modul1-giris.html
            $table->string('type')->default('html'); // html, pdf, md
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0); // Görüntülenme sayısı
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_notes');
        Schema::dropIfExists('study_categories');
    }
};
