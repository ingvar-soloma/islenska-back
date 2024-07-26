<?php

use App\Http\Controllers\Api\AudioFileController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resources([
    'translation' => TranslationController::class,
    'audioFile' => AudioFileController::class,
    'language' => LanguageController::class,
    'level' => LevelController::class,
    'topic' => TopicController::class,
    'word' => WordController::class,
]);

