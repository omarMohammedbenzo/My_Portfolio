<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->json('name');                                        // {en, ar}
            $table->string('category', 20)->default('other')->index();   // frontend|backend|tools|other
            $table->unsignedTinyInteger('level')->default(3);            // 1–5
            $table->string('icon', 100)->nullable();                     // Lucide icon name or SVG slug

            $table->unsignedInteger('order')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
