<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_dictionaries', function (Blueprint $table) {
            $table->unique(['name', 'word_id']);
        });
    }

    public function down(): void
    {
        Schema::table('user_dictionaries', function (Blueprint $table) {
            $table->dropUnique(['user_dictionaries_user_id_word_id_unique']);
        });
    }
};
