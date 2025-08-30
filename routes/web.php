<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\PasienController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('rumah_sakit', [RumahSakitController::class,'index'])->name('rumah_sakit.index');
    Route::post('rumah_sakit', [RumahSakitController::class,'store'])->name('rumah_sakit.store');
    Route::delete('rumah_sakit/{id}', [RumahSakitController::class,'destroy'])->name('rumah_sakit.destroy');
    Route::put('rumah_sakit/{id}', [RumahSakitController::class,'ajaxUpdate'])->name('rumah_sakit.ajaxUpdate');

    Route::get('pasien', [PasienController::class,'index'])->name('pasien.index');
    Route::post('pasien', [PasienController::class,'store'])->name('pasien.store');
    Route::post('pasien/{id}', [PasienController::class,'ajaxUpdate'])->name('pasien.ajaxUpdate');
    Route::delete('pasien/{id}', [PasienController::class,'destroy'])->name('pasien.destroy');
    Route::get('pasien/filter/{rumah_sakit_id}', [PasienController::class,'filter'])->name('pasien.filter');
});
