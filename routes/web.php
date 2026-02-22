<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// dashboard pages
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// tips pages
Route::get('/tips', [PaymentController::class, 'index'])->name('tips');

Route::post('payments/process', [PaymentController::class, 'processPayment'])
    ->name('payments.process');

Route::get('/payments/success', [PaymentController::class, 'success'])
    ->name('payments.success');

Route::get('/payments/cancel', [PaymentController::class, 'cancel'])
    ->name('payments.cancel');


Route::get('images/{path}', function ($path) {

    $fullPath = Storage::disk('local')->path($path);

    if (! File::exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath, [
        'Cache-Control' => 'private, max-age=31536000',
    ]);
})->where('path', '.*')->name('image.show')->middleware(['auth', 'verified']);

require __DIR__ . '/merchant.php';
require __DIR__ . '/BusinessType.php';
require __DIR__ . '/Branch.php';
require __DIR__ . '/employee.php';
require __DIR__ . '/contract.php';
