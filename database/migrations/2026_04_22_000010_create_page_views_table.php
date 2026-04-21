<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();

            $table->string('page_url', 512)->index();
            $table->char('ip_hash', 64)->index();     // sha256 + app key
            $table->string('session_id', 128)->nullable()->index(); // for unique visitor counts
            $table->text('user_agent')->nullable();
            $table->string('referrer', 512)->nullable();
            $table->char('country', 2)->nullable();   // ISO 3166-1 alpha-2

            // created_at doubles as view timestamp; updated_at not needed but schema requires it
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
