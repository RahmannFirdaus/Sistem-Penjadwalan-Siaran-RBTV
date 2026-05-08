<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\AdminController; // Tambahkan pemanggilan AdminController

// --- HALAMAN UTAMA & LOGIN ---
Route::get('/', function () { 
    if(auth()->check()) {
        return auth()->user()->role === 'admin' ? redirect('/admin/dashboard') : redirect('/dashboard');
    }
    return view('auth.login'); 
})->name('login');

// --- OTENTIKASI GOOGLE ---
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');


// --- GRUP KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Alamat: /admin/dashboard (Logika sudah rapi dipindah ke AdminController)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Alamat: /admin/jadwal
    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('admin.jadwal');
    Route::post('/jadwal', [ScheduleController::class, 'store'])->name('admin.jadwal.store');
    Route::put('/jadwal/{id}', [ScheduleController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/jadwal/{id}', [ScheduleController::class, 'destroy'])->name('admin.jadwal.destroy');
    Route::get('/jadwal/export', [ScheduleController::class, 'export'])->name('schedules.export');

    // Alamat: /admin/riwayat-login
    Route::get('/riwayat-login', [LoginHistoryController::class, 'index'])->name('admin.history');
    Route::get('/riwayat-login/export', [LoginHistoryController::class, 'export'])->name('admin.history.export');

    // Alamat: /admin/staf
    Route::get('/staf', [StafController::class, 'index'])->name('admin.staf.index');
    Route::post('/staf', [StafController::class, 'store'])->name('admin.staf.store');
    Route::put('/staf/{id}', [StafController::class, 'update'])->name('admin.staf.update');
    Route::delete('/staf/{id}', [StafController::class, 'destroy'])->name('admin.staf.destroy');
});


// --- GRUP KHUSUS STAF ---
Route::middleware(['auth', 'role:staf'])->group(function () {
    // Alamat: /dashboard
    Route::get('/dashboard', [ScheduleController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [ScheduleController::class, 'export'])->name('staf.jadwal.export');
});