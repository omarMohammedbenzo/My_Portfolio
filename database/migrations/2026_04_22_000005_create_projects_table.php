<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->json('title');                    // {en, ar}
            $table->string('slug', 255)->unique();
            $table->json('description');              // {en, ar} — short (cards)
            $table->json('long_description')->nullable(); // {en, ar} — detail page
            $table->json('tech_stack')->nullable();   // ["Laravel","Vue","MySQL"]
            $table->json('gradient_colors')->nullable(); // {from, via, to} Tailwind color classes for placeholder

            $table->string('cover_image', 512)->nullable(); // relative path, null until uploaded
            $table->string('live_url', 512)->nullable();
            $table->string('github_url', 512)->nullable();

            $table->boolean('featured')->default(false)->index();
            $table->string('status', 15)->default('published')->index(); // draft|published|archived
            $table->smallInteger('year')->unsigned()->nullable();

            $table->unsignedInteger('order')->default(0)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
