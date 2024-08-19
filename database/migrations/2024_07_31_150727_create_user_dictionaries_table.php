<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->integer('level_of_knowing');
            $table->integer('stability');
            $table->timestamps();
//            $table->unique(['user_id', 'word_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_dictionaries');
    }
};
