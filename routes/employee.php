<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::middleware(['auth', 'verified'])->prefix('employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])
        ->name('show');
    Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('delete');
    Route::get('/qrcode/{id}', [EmployeeController::class, 'generateQr'])->name('qrcode');

    });
    Route::get('employees/pay/{employee}', [EmployeeController::class, 'paymentPage'])
        ->name('employees.pay');
