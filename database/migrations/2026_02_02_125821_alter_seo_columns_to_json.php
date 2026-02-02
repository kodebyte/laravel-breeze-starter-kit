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
        Schema::table('seo', function (Blueprint $table) {
            // Ubah kolom jadi JSON biar support multi-bahasa
            $table->json('title')->nullable()->change();
            $table->json('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }
};
