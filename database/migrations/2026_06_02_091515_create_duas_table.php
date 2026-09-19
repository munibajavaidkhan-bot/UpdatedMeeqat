<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('duas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('title_en', 200);
            $table->longText('arabic_text');
            $table->longText('transliteration')->nullable();
            $table->longText('translation_en')->nullable();
            $table->longText('translation_ur')->nullable();
            $table->string('reference', 255)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

        });
    }
    public function down(): void { Schema::dropIfExists('duas'); }
};