<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessTypeController;

Route::middleware(['auth', 'verified','role:super_admin'])->group(function () {
    Route::prefix('business-types')->name('business_types.')->group(function () {

        Route::get('/', [BusinessTypeController::class, 'index'])->name('index');
        Route::post('/', [BusinessTypeController::class, 'store'])->name('store');
        Route::put('/{businessType}', [BusinessTypeController::class, 'update'])->name('update');
        Route::delete('/{businessType}', [BusinessTypeController::class, 'destroy'])->name('delete');
        
    });
});

