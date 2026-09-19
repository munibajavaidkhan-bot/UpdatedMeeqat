<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ihram_guides', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content_ur');
        });
    }

    public function down(): void
    {
        Schema::table('ihram_guides', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
