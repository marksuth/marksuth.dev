<?php

declare(strict_types=1);

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
        Schema::table('posts', function (Blueprint $table): void {
            // Add indexes to commonly filtered columns
            $table->index('post_type_id', 'posts_post_type_id_index');
            $table->index('collection_id', 'posts_collection_id_index');
            $table->index('published_at', 'posts_published_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            // Drop the indexes added in up()
            $table->dropIndex('posts_post_type_id_index');
            $table->dropIndex('posts_collection_id_index');
            $table->dropIndex('posts_published_at_index');
        });
    }
};
