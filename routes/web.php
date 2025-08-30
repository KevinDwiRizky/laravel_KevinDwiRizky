<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RumahSakitController;

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

    Route::post('rumah_sakit/{id}', [RumahSakitController::class,'ajaxUpdate'])->name('rumah_sakit.ajaxUpdate');


});
