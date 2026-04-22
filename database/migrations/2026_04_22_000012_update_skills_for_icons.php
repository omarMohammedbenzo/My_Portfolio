<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->renameColumn('icon', 'icon_slug');
            $table->string('icon_set', 20)->default('simple-icons')->after('icon_slug');
            $table->string('icon_color', 30)->nullable()->after('icon_set');
            $table->unsignedTinyInteger('years')->nullable()->after('icon_color');
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['icon_set', 'icon_color', 'years']);
            $table->renameColumn('icon_slug', 'icon');
        });
    }
};
