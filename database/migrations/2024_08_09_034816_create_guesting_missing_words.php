<?php

use App\Models\TextEntityGuesting;
use App\Models\Word;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('guesting_missing_words', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TextEntityGuesting::class);
            $table->foreignIdFor(Word::class);
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('guesting_missing_words');
    }
};
