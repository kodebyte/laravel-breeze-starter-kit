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
        Schema::table('pages', function (Blueprint $table) {
            // JSON biar bisa ID & EN
            $table->json('content')->nullable()->after('slug'); 
            
            // Flag buat nandain: Halaman ini boleh diedit kontennya gak?
            // Kalau False (About Us), editor disembunyikan.
            // Kalau True (Privacy), editor muncul.
            $table->boolean('is_editable')->default(false)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumns([
                'content',
                'is_editable'
            ]);
        });
    }
};
