<?php

use App\Http\Controllers\AdditionalInfoController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\crudeController;
use App\Http\Controllers\Multi;

Route::get('/',function(){
    return view("default");
} )->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/InvalidCodes', function () {
    return view('default1');
})->name('dashboard1');



Route::middleware(['admin'])->group(function () {
    Route::get('/crud', [crudeController::class , 'index'])->name('dashboardCrud');
    Route::get('/edit/{id}', [crudeController::class , 'edit'])->name('getFormData');
    Route::get('/create', [crudeController::class , 'create'])->name('create');
    Route::post('/store', [crudeController::class , 'store'])->name('store');
    Route::put('/update/{id}' , [crudeController::class , 'update'])->name('update');
    Route::delete('delete/{id}' , [crudeController::class, 'delete'])->name('delete');    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 



Route::post('process/{type}', [ParkController::class, 'ExportWithoutInvalideCodes'])->name('process');
Route::post('processExport/{type}', [ParkController::class, 'Export'])->name('processExport');




require __DIR__ . '/auth.php';