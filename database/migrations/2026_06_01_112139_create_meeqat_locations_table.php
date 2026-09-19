<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeqat_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en', 150);
            $table->string('name_ar', 150);
            $table->string('name_ur', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('description_ur')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('for_pilgrims_from')->nullable();
            $table->string('color', 20)->default('#22c55e');
            $table->string('icon', 50)->default('📍');
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeqat_locations');
    }
};