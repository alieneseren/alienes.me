<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blog posts tablosunu genişlet - mevcut veriyi koru
     */
    public function up(): void
    {
        // Tablo yoksa oluştur
        if (!Schema::hasTable('blog_posts')) {
            Schema::create('blog_posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('excerpt')->nullable();
                $table->longText('content');
                $table->string('featured_image')->nullable();
                $table->boolean('is_published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->string('meta_description')->nullable();
                $table->timestamps();
            });
        } else {
            // Tablo varsa, eksik kolonları ekle
            Schema::table('blog_posts', function (Blueprint $table) {
                if (!Schema::hasColumn('blog_posts', 'title')) {
                    $table->string('title')->after('id');
                }
                if (!Schema::hasColumn('blog_posts', 'slug')) {
                    $table->string('slug')->unique()->after('title');
                }
                if (!Schema::hasColumn('blog_posts', 'excerpt')) {
                    $table->text('excerpt')->nullable()->after('slug');
                }
                if (!Schema::hasColumn('blog_posts', 'content')) {
                    $table->longText('content')->after('excerpt');
                }
                if (!Schema::hasColumn('blog_posts', 'featured_image')) {
                    $table->string('featured_image')->nullable()->after('content');
                }
                if (!Schema::hasColumn('blog_posts', 'is_published')) {
                    $table->boolean('is_published')->default(false)->after('featured_image');
                }
                if (!Schema::hasColumn('blog_posts', 'published_at')) {
                    $table->timestamp('published_at')->nullable()->after('is_published');
                }
                if (!Schema::hasColumn('blog_posts', 'meta_description')) {
                    $table->string('meta_description')->nullable()->after('published_at');
                }
            });
        }

        // blog_post_tag pivot tablosu (çoklu etiket)
        if (!Schema::hasTable('tags')) {
            Schema::create('tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blog_post_tag')) {
            Schema::create('blog_post_tag', function (Blueprint $table) {
                $table->id();
                $table->foreignId('blog_post_id')->constrained('blog_posts')->onDelete('cascade');
                $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
                $table->timestamps();
                $table->unique(['blog_post_id', 'tag_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');
        Schema::dropIfExists('tags');
        // blog_posts tablosunu silme - veriler önemli
    }
};
