<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('niyat', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hajj', 'umrah', 'hajj_umrah', 'tawaf', 'sai', 'other']);
            $table->string('title_en', 200);
            $table->longText('arabic_text');
            $table->longText('transliteration')->nullable();
            $table->longText('translation_en')->nullable();
            $table->longText('translation_ur')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('niyat'); }
};