<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();
        $existingIndexes = [];

        if ($driver === 'mysql') {
            $database = $connection->getDatabaseName();
            $rows = $connection->select(
                "SELECT index_name FROM information_schema.statistics WHERE table_schema = ? AND table_name = 'posts'",
                [$database]
            );
            $existingIndexes = collect($rows)->pluck('index_name')->all();
        }

        Schema::table('posts', function (Blueprint $table) use ($existingIndexes) {
            // Use explicit names to avoid Laravel guessing and to check existence reliably
            if (!in_array('posts_post_type_id_index', $existingIndexes, true)) {
                $table->index('post_type_id', 'posts_post_type_id_index');
            }
            if (!in_array('posts_collection_id_index', $existingIndexes, true)) {
                $table->index('collection_id', 'posts_collection_id_index');
            }
            if (!in_array('posts_published_at_index', $existingIndexes, true)) {
                $table->index('published_at', 'posts_published_at_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();
        $existingIndexes = [];

        if ($driver === 'mysql') {
            $database = $connection->getDatabaseName();
            $rows = $connection->select(
                "SELECT index_name FROM information_schema.statistics WHERE table_schema = ? AND table_name = 'posts'",
                [$database]
            );
            $existingIndexes = collect($rows)->pluck('index_name')->all();
        }

        Schema::table('posts', function (Blueprint $table) use ($existingIndexes) {
            if (in_array('posts_post_type_id_index', $existingIndexes, true)) {
                $table->dropIndex('posts_post_type_id_index');
            }
            if (in_array('posts_collection_id_index', $existingIndexes, true)) {
                $table->dropIndex('posts_collection_id_index');
            }
            if (in_array('posts_published_at_index', $existingIndexes, true)) {
                $table->dropIndex('posts_published_at_index');
            }
        });
    }
};
