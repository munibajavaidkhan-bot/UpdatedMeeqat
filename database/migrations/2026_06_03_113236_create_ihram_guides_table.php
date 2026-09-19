<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ihram_guides', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('category', ['men', 'women', 'general', 'prohibited', 'recommended']);
            $table->string('title_en', 200);
            $table->string('title_ur', 200)->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_ur')->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ihram_guides'); }
};