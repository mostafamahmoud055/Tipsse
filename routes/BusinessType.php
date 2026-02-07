<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessTypeController;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('business-types')->name('business_types.')->group(function () {
        Route::get('/', [BusinessTypeController::class, 'index'])->name('index');
        // Route::get('/create', [BusinessTypeController::class, 'create'])->name('create');
        Route::post('/', [BusinessTypeController::class, 'store'])->name('store');
        // Route::get('/{businessType}/edit', [BusinessTypeController::class, 'edit'])->name('edit');
        Route::put('/{businessType}', [BusinessTypeController::class, 'update'])->name('update');
        Route::delete('/{businessType}', [BusinessTypeController::class, 'destroy'])->name('destroy');
    });
});
