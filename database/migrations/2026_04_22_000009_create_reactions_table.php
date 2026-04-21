<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();

            $table->string('page_url', 512)->index();
            $table->char('ip_hash', 64)->index();    // sha256 hex of IP
            $table->text('user_agent')->nullable();
            $table->char('country', 2)->nullable();  // ISO 3166-1 alpha-2

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
