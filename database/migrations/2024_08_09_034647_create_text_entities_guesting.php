<?php

use App\Models\TextEntity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    final public function up(): void
    {
        Schema::create('text_entity_guestings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TextEntity::class);
            $table->timestamps();
        });
    }

    final public function down(): void
    {
        Schema::dropIfExists('text_entity_guestings');
    }
};
