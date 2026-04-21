<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id();

            // Singleton guard — only one 'main' row ever
            $table->string('type', 20)->default('main')->unique();

            // Translatable JSON fields
            $table->json('name');        // {en, ar}
            $table->json('title');       // {en, ar}
            $table->json('summary');     // {en, ar}
            $table->json('location');    // {en, ar}
            $table->json('socials');     // {github, linkedin, twitter, ...}

            // Plain fields
            $table->string('email', 255)->nullable();
            $table->string('phone', 30)->nullable();

            // Avatar managed by Spatie Media Library (no column needed)
            // meta: for future arbitrary settings/SEO per-page overrides
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_info');
    }
};
