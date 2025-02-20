<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Invoices\Presentation\Http\InvoiceController;


Route::prefix('invoices')->group(function () {
    Route::post('/', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoice.show'); 
    Route::post('/send', [InvoiceController::class, 'send'])->name('invoice.send');
    //Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
});