<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoExportController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/exportcsv', [InfoExportController::class, 'exportUserInfoAsCSV'])->name('exportCSV');
    Route::get('/exportpdf', [InfoExportController::class, 'exportUserInfoAsPDF'])->name('exportPDF');
    Route::get('/fetchUsers', [InfoExportController::class, 'fetchUsers'])->name('fetchUsers');
});