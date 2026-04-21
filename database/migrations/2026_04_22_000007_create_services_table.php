<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->json('title');        // {en, ar}
            $table->json('description');  // {en, ar}
            $table->string('icon', 100)->nullable(); // Lucide icon name

            $table->unsignedInteger('order')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
