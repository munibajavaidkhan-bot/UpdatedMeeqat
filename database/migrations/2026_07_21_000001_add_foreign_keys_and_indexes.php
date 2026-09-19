<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // FK constraint on users.role_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->index('role_id');
            $table->index('is_active');
        });

        // Indexes on roles
        Schema::table('roles', function (Blueprint $table) {
            $table->unique('name');
        });

        // Indexes on permissions
        Schema::table('permissions', function (Blueprint $table) {
            $table->unique('name');
            $table->index('module');
        });

        // Indexes on activity_logs
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('action');
            $table->index('module');
            $table->index('created_at');
        });

        // Indexes on contact_messages
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('is_read');
            $table->index('email');
        });

        // Indexes on chaddar_size_rules
        Schema::table('chaddar_size_rules', function (Blueprint $table) {
            $table->index('is_active');
            $table->unique(['style', 'size_label']);
        });

        // Indexes on chaddar_calculations
        Schema::table('chaddar_calculations', function (Blueprint $table) {
            $table->index('user_id');
        });

        // Indexes on meeqat_locations
        Schema::table('meeqat_locations', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order']);
            $table->index(['latitude', 'longitude']);
        });

        // Indexes on meeqat_distance_logs
        Schema::table('meeqat_distance_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('nearest_meeqat_id');
            $table->index('detection_method');
        });

        // Indexes on categories
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Indexes on duas
        Schema::table('duas', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('is_active');
        });

        // Indexes on niyat
        Schema::table('niyat', function (Blueprint $table) {
            $table->index('type');
            $table->index('is_active');
        });

        // Indexes on ihram_guides
        Schema::table('ihram_guides', function (Blueprint $table) {
            $table->index('category');
            $table->index(['category', 'is_active', 'sort_order']);
        });

        // Unique constraint + NOT NULL on user_dua_bookmarks
        Schema::table('user_dua_bookmarks', function (Blueprint $table) {
            $table->unique(['user_id', 'dua_id']);
            $table->index('user_id');
            $table->index('dua_id');
        });

        // Make dua_id NOT NULL
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE user_dua_bookmarks MODIFY dua_id BIGINT UNSIGNED NOT NULL;');
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropIndex(['module']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['action']);
            $table->dropIndex(['module']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['is_read']);
            $table->dropIndex(['email']);
        });

        Schema::table('chaddar_size_rules', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropUnique(['style', 'size_label']);
        });

        Schema::table('chaddar_calculations', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('meeqat_locations', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'sort_order']);
            $table->dropIndex(['latitude', 'longitude']);
        });

        Schema::table('meeqat_distance_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['nearest_meeqat_id']);
            $table->dropIndex(['detection_method']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('duas', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('niyat', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('ihram_guides', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['category', 'is_active', 'sort_order']);
        });

        Schema::table('user_dua_bookmarks', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'dua_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['dua_id']);
        });
    }
};
