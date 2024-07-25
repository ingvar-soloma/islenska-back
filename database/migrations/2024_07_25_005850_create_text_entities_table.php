<?php

use App\Models\AudioFile;
use App\Models\Level;
use App\Models\Topic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('text_entities', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignIdFor(Level::class);
            $table->foreignIdFor(Topic::class);
            $table->foreignIdFor(AudioFile::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_entities');
    }
};
