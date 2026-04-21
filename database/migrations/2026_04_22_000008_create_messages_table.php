<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('subject', 500)->nullable();
            $table->text('body');

            $table->string('ip', 45)->nullable();           // raw on receipt, only stored temporarily
            $table->text('user_agent')->nullable();

            $table->timestamp('read_at')->nullable()->index();
            $table->timestamp('replied_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
