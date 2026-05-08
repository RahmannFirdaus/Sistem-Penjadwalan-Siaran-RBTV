<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Schedule as JadwalSiaran;
use Carbon\Carbon;

// Robot "Housekeeping" RBTV: Menghapus jadwal yang usianya lebih dari 2 minggu (14 hari)
Schedule::call(function () {
    // Tentukan titik batas waktu (Hari ini dikurangi 2 minggu)
    $batasWaktu = Carbon::today('Asia/Jakarta')->subWeeks(2)->toDateString();
    
    // Hapus semua jadwal yang tanggalnya lebih kecil (lebih lama) dari batas waktu
    $jumlahDihapus = JadwalSiaran::whereDate('date', '<', $batasWaktu)->delete();

    // Opsional: Mencatat aktivitas robot ke dalam file log Laravel (storage/logs/laravel.log)
    if ($jumlahDihapus > 0) {
        \Illuminate\Support\Facades\Log::info("Housekeeping: $jumlahDihapus jadwal siaran lama berhasil dihapus otomatis.");
    }
    
})->dailyAt('00:01'); // Robot akan dieksekusi setiap hari pada jam 00:01 tengah malam WIB