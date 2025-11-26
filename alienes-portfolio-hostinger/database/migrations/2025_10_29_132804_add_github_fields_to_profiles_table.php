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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('github_username')->nullable()->after('github_url');
            $table->string('github_avatar_url')->nullable()->after('github_username');
            $table->text('github_bio')->nullable()->after('github_avatar_url');
            $table->string('github_company')->nullable()->after('github_bio');
            $table->string('github_blog')->nullable()->after('github_company');
            $table->integer('github_followers')->default(0)->after('github_blog');
            $table->integer('github_following')->default(0)->after('github_followers');
            $table->integer('github_public_repos')->default(0)->after('github_following');
            $table->timestamp('github_synced_at')->nullable()->after('github_public_repos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'github_username',
                'github_avatar_url',
                'github_bio',
                'github_company',
                'github_blog',
                'github_followers',
                'github_following',
                'github_public_repos',
                'github_synced_at',
            ]);
        });
    }
};
