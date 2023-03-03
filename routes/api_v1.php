<?php

use App\Http\Controllers\API\V1\CarAutocompleteController;
use App\Http\Controllers\API\V1\StolenCarController;
use Illuminate\Support\Facades\Route;

Route::post('cars', [StolenCarController::class, 'store'])->name('store');
Route::get('cars', [StolenCarController::class, 'index'])->name('index');
Route::get('cars/{export}', [StolenCarController::class, 'exportFiltered'])->name('exportFiltered');
Route::put('cars/{vin}', [StolenCarController::class, 'update'])->name('update');
Route::delete('cars/{vin}', [StolenCarController::class, 'destroy'])->name('destroy');

Route::get('car-models-by-make/{makeName}', [CarAutocompleteController::class, 'searchByMakeName']);
