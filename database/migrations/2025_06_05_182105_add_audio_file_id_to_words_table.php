<?php

use App\Models\AudioFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->foreignIdFor(AudioFile::class)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropForeign(['audio_file_id']);
            $table->dropColumn('audio_file_id');
        });
    }
};
