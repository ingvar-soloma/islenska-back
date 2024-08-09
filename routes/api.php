<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuestingMissingWordController;
use App\Http\Controllers\Api\ReadingProgressController;
use App\Http\Controllers\Api\TextEntityGuestingController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\TextEntityController;
use App\Http\Controllers\Api\AudioFileController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserDictionaryController;
use App\Http\Controllers\Api\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'revokeAll'])->name('logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resources([
        'guesting_missing_word' => GuestingMissingWordController::class,
        'text_entity_guesting' => TextEntityGuestingController::class,
        'reading_progress' => ReadingProgressController::class,
        'user_dictionary' => UserDictionaryController::class,
        'translation' => TranslationController::class,
        'text_entity' => TextEntityController::class,
        'audio_file' => AudioFileController::class,
        'language' => LanguageController::class,
        'level' => LevelController::class,
        'topic' => TopicController::class,
        'word' => WordController::class,
    ]);

});




