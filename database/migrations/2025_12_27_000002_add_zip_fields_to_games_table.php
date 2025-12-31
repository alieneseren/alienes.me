<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Games tablosuna ZIP upload desteği ekle
     */
    public function up(): void
    {
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                if (!Schema::hasColumn('games', 'zip_path')) {
                    $table->string('zip_path')->nullable()->after('is_active');
                }
                if (!Schema::hasColumn('games', 'extracted_path')) {
                    $table->string('extracted_path')->nullable()->after('zip_path');
                }
                if (!Schema::hasColumn('games', 'entry_file')) {
                    $table->string('entry_file')->default('index.html')->after('extracted_path');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                $table->dropColumn(['zip_path', 'extracted_path', 'entry_file']);
            });
        }
    }
};
