<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\DashboardController;


// dashboard pages
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);


// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');


// tips pages
Route::get('/tips', function () {
    return view('pages.tips', ['title' => 'Tip']);
})->name('tips');

// settings pages
Route::get('/settings', function () {
    return view('pages.settings', [
        'title' => 'Settings',
        'merchant_name' => 'Ibraheem Ahmed Alwoor',
        'business_name' => 'Test Business',
        'merchant_email' => 'ibraheem.alaoor@hotmail.com',
        'merchant_phone' => '0598298969'
    ]);
})->name('settings');


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
