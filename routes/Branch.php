<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/branches', [BranchController::class, 'index'])
        ->name('branches.index');

    Route::post('/branches', [BranchController::class, 'store'])
        ->name('branches.store');

    Route::get('/branches/{branch}', [BranchController::class, 'show'])
        ->name('branches.show');

    Route::put('/branches/{branch}', [BranchController::class, 'update'])
        ->name('branches.update');

    Route::delete('/branches/{branch}', [BranchController::class, 'destroy'])
        ->name('branches.delete');

    Route::get('/search-merchant-owners', [BranchController::class, 'searchOwners'])
        ->name('branches.search-owners');

        Route::get('/merchants/{merchant}/branches', [BranchController::class, 'branches']) ->name('branches.search');

});
