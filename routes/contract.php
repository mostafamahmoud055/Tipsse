<?php

use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;

Route::prefix('contract')->name('contract.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [ContractController::class, 'index'])->name('index');
    Route::delete('/{contract}', [ContractController::class, 'destroy'])->name('delete');

    Route::put('/{application}/edit', [ContractController::class, 'update'])
        ->name('update');

    Route::put('/{contract}', [ContractController::class, 'edit'])
        ->name('edit');

    Route::post('/', [ContractController::class, 'store'])
        ->name('store');

    Route::delete('/{contract}', [ContractController::class, 'destroy'])
        ->name('delete');


    // routes/web.php
    Route::get('/merchant-contract/pdf', [ContractController::class, 'downloadPDF'])->name('pdf');
});
