<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chaddar_size_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('style', ['full', 'shoulder'])->index();
            $table->decimal('height_min_cm', 5, 2);
            $table->decimal('height_max_cm', 5, 2);
            $table->decimal('fabric_meters', 4, 2);
            $table->string('size_label', 50)->nullable();  // XS, S, M, L, XL, XXL
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chaddar_size_rules');
    }
};