<?php

use App\Http\Controllers\Api\XenditCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/xendit/callback', [XenditCallbackController::class, '__invoke'])->name('xendit.callback')->withoutMiddleware('auth:sanctum');
