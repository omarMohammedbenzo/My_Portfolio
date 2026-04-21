<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();

            $table->string('school', 255);
            $table->json('degree');    // {en, ar}
            $table->json('field');     // {en, ar}
            $table->json('location')->nullable(); // {en, ar}
            $table->json('description')->nullable(); // {en, ar}

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->unsignedInteger('order')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
