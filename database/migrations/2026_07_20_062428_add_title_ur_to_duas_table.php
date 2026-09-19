<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('duas', function (Blueprint $table) {
            $table->string('title_ur', 200)->nullable()->after('title_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('duas', function (Blueprint $table) {
            $table->dropColumn('title_ur');
        });
    }
};
