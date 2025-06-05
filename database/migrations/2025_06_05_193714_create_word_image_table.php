<?php

use App\Models\Image;
use App\Models\Word;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('word_image', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Word::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Image::class)->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('word_image');
    }
};
