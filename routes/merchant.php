<?php

use App\Http\Controllers\MerchantApplicationController;
use Illuminate\Support\Facades\Route;

Route::name('merchants.')->middleware(['auth', 'verified','role:super_admin'])->group(function () {

    Route::get('/Merchants', [MerchantApplicationController::class, 'index'])->name('index');
    Route::post('/merchants/store', [MerchantApplicationController::class, 'createNewMerchant'])->name('store');

    Route::get('/merchants/{application}', [MerchantApplicationController::class, 'show'])->name('show');

    Route::post('/merchants/apply', [MerchantApplicationController::class, 'apply'])->name('apply');
    Route::post('/merchants/{application}/approve', [MerchantApplicationController::class, 'approve'])->name('approve');
    Route::post('/merchants/{application}/reject', [MerchantApplicationController::class, 'reject'])->name('reject');

    Route::delete('/merchants/{application}', [MerchantApplicationController::class, 'destroy'])->name('delete');

    Route::put('merchants/{application}/edit', [MerchantApplicationController::class, 'edit'])
        ->name('edit');

    // merchant application pages
});

Route::get('/merchant-application', [MerchantApplicationController::class, 'index'])->name('merchant-application')->middleware(['auth', 'verified','role:super_admin']);
Route::get('/contracts', [MerchantApplicationController::class, 'index'])->name('contracts')->middleware(['auth', 'verified','role:super_admin']);
