<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeqat_distance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            $table->string('session_id', 100)->nullable()->index();
            $table->decimal('user_latitude', 10, 8);
            $table->decimal('user_longitude', 11, 8);
            $table->string('user_country', 100)->nullable();
            $table->string('user_city', 100)->nullable();
            $table->unsignedInteger('nearest_meeqat_id')->nullable();
            $table->decimal('nearest_distance_km', 10, 2)->nullable();
            $table->json('all_distances')->nullable();
            $table->string('detection_method', 20)->default('gps');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('nearest_meeqat_id')
                  ->references('id')
                  ->on('meeqat_locations')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeqat_distance_logs');
    }
};