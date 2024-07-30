<?php

use App\Models\TextEntity;
use App\Models\Word;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('word_text_entity', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Word::class);
            $table->foreignIdFor(TextEntity::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('word_text_entity');
    }
};
