<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();

            $table->string('company', 255);
            $table->json('role');          // {en, ar}
            $table->json('location');      // {en, ar}
            $table->json('description');   // {en, ar} — HTML / bullet list

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false)->index();

            // PHP-backed enums stored as strings
            $table->string('employment_type', 20)->default('full-time');
            $table->string('location_type', 10)->default('on-site');

            $table->unsignedInteger('order')->default(0)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
