<?php

use App\Http\Controllers\Api\AudioFileController;
use App\Http\Controllers\Api\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resources([
    'language' => LanguageController::class,
    'audioFile' => AudioFileController::class,
]);

