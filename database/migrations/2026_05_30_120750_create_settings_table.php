<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 100)->unique();
            $table->longText('value')->nullable();
            $table->enum('type', ['text', 'number', 'boolean', 'json', 'image'])->default('text');
            $table->string('group', 50)->default('general');
            $table->string('label', 150)->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};