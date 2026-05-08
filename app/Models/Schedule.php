<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model {
    protected $guarded = [];

    // Algoritma pengecekan jadwal tumpang tindih 
    public static function isOverlapping($date, $startTime, $duration, $excludeId = null)
        {
            // 1. Pastikan durasi dipaksa (di-casting) menjadi integer
            $durasiAngka = (int) $duration; 
            
            // 2. Hitung waktu selesai
            $start = Carbon::parse($startTime);
            $end = $start->copy()->addMinutes($durasiAngka);

            $query = self::where('date', $date)
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end->format('H:i'))
                    ->where('end_time', '>', $start->format('H:i'));
                });

            // Kecualikan ID jika sedang melakukan proses Update
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            return $query->exists();
        }
}