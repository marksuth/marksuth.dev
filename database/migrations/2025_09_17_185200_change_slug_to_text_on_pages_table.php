<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            // MySQL / MariaDB
            DB::statement('ALTER TABLE `pages` MODIFY `slug` TEXT');
        } elseif ($driver === 'pgsql') {
            // PostgreSQL
            DB::statement('ALTER TABLE pages ALTER COLUMN slug TYPE TEXT');
        } elseif ($driver === 'sqlite') {
            // SQLite does not support altering column types directly in a portable way
            Schema::table('pages', function (Blueprint $table) {
                $table->text('slug_new')->nullable();
            });

            DB::table('pages')->update(['slug_new' => DB::raw('slug')]);

            // Drop the existing unique index if it exists (Laravel default naming convention)
            try {
                Schema::table('pages', function (Blueprint $table) {
                    $table->dropUnique('pages_slug_unique');
                });
            } catch (Throwable $e) {
                // index might not exist; ignore
            }

            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('slug');
            });

            Schema::table('pages', function (Blueprint $table) {
                $table->renameColumn('slug_new', 'slug');
            });

            Schema::table('pages', function (Blueprint $table) {
                $table->unique('slug');
            });
        } else {
            // Fallback: try Laravel's change() which requires doctrine/dbal
            Schema::table('pages', function (Blueprint $table) {
                $table->text('slug')->change();
            });
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `pages` MODIFY `slug` VARCHAR(255)');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE pages ALTER COLUMN slug TYPE VARCHAR(255)');
        } elseif ($driver === 'sqlite') {
            // Reverse for SQLite using the same rebuild approach
            Schema::table('pages', function (Blueprint $table) {
                $table->string('slug_new')->nullable();
            });

            DB::table('pages')->update(['slug_new' => DB::raw('slug')]);

            try {
                Schema::table('pages', function (Blueprint $table) {
                    $table->dropUnique('pages_slug_unique');
                });
            } catch (Throwable $e) {
                // ignore if not exists
            }

            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('slug');
            });

            Schema::table('pages', function (Blueprint $table) {
                $table->renameColumn('slug_new', 'slug');
            });

            Schema::table('pages', function (Blueprint $table) {
                $table->unique('slug');
            });
        } else {
            Schema::table('pages', function (Blueprint $table) {
                $table->string('slug')->change();
            });
        }
    }
};
