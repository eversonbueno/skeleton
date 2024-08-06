<?php

use App\Http\Controllers\EbanxController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/reset', [EbanxController::class, 'reset'])->name('ebanx.reset');

Route::get('/balance', [EbanxController::class, 'balance'])->name('ebanx.balance');

Route::post('/event', [EbanxController::class, 'event'])->name('ebanx.event');
