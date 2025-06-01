<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('webLogin');

Route::get('/get_audio/{filename}', function ($filename) {
    $path = storage_path('app/public/audio/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
