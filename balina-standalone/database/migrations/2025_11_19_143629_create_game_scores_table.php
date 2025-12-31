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
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('game_name', 50);
            $table->integer('score');
            $table->integer('level')->nullable();
            $table->integer('time')->nullable(); // saniye cinsinden
            $table->json('extra_data')->nullable(); // ek veriler için
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            $table->index(['game_name', 'score']);
            $table->index(['username', 'game_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
};
