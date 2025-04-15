<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('pegawai')->middleware(['auth'])->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/store', [PegawaiController::class, 'store'])->name('pegawai.store');    // POST
    Route::put('/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update'); // PUT
    Route::get('/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::delete('/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
});
