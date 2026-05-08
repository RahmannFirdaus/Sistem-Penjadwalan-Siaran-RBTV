<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', Carbon::today('Asia/Jakarta')->toDateString());
        $search = $request->query('search');

        $query = Schedule::whereDate('date', $date);

        if ($search) {
            $query->where('program_name', 'like', '%' . $search . '%');
        }

        $schedules = $query->orderBy('start_time', 'asc')->get();

        // Pastikan nama folder view 'schedule' sesuai dengan folder kamu
        return view('schedules.index', compact('schedules', 'date'));
    }

    public function export(Request $request)
    {

        $date = $request->query('date', Carbon::today('Asia/Jakarta')->toDateString());
        $schedules = Schedule::whereDate('date', $date)->orderBy('start_time', 'asc')->get();

        $fileName = "Jadwal_RBTV_" . $date . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function() use($schedules) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Mulai', 'Selesai', 'Program', 'Durasi', 'Status']);

            $now = Carbon::now('Asia/Jakarta');

            foreach ($schedules as $item) {
                $start = Carbon::parse($item->date . ' ' . $item->start_time, 'Asia/Jakarta');
                $end = Carbon::parse($item->date . ' ' . $item->end_time, 'Asia/Jakarta');

                if ($now->lt($start)) { $status = 'SIAP'; }
                elseif ($now->between($start, $end)) { $status = 'BERLANGSUNG'; }
                else { $status = 'SELESAI'; }

                fputcsv($file, [
                    Carbon::parse($item->date)->format('d-M-Y'),
                    $item->start_time,
                    $item->end_time,
                    $item->program_name,
                    $item->duration . ' Menit',
                    $status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') { 
            return back()->withErrors(['auth' => 'Akses ditolak.']); 
        }

        $request->validate([
            'date' => 'required|date',
            'program_name' => 'required|string',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1',
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $inputTime = Carbon::parse($request->date . ' ' . $request->start_time, 'Asia/Jakarta');

        // Validasi 5 Menit
        if ($inputTime->isPast()) {
            if ($now->diffInMinutes($inputTime, false) < -5) {
                return back()->withErrors(['start_time' => 'Gagal! Waktu program sudah lewat lebih dari 5 menit.'])
                             ->withInput();
            }
        }

        $endTime = Carbon::parse($request->start_time)->addMinutes((int)$request->duration)->format('H:i');
        
        // Panggil algoritma dari Model Schedule
        if (Schedule::isOverlapping($request->date, $request->start_time, $request->duration)) {
            return back()->withErrors(['start_time' => 'Gagal! Waktu ini bertabrakan dengan jadwal program lain.'])->withInput();
        }

        Schedule::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'program_name' => $request->program_name,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'end_time' => $endTime,
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') { 
            return back()->withErrors(['auth' => 'Akses ditolak.']); 
        }

        $schedule = Schedule::findOrFail($id);
        
        $request->validate([
            'program_name' => 'required|string',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1',
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $tanggal = $request->date ?? $schedule->date;
        $inputTime = Carbon::parse($tanggal . ' ' . $request->start_time, 'Asia/Jakarta');

        // Validasi 5 Menit di Update
        if ($inputTime->isPast()) {
            if ($now->diffInMinutes($inputTime, false) < -5) {
                return back()->withErrors(['start_time' => 'Gagal! Tidak bisa mengubah ke waktu yang sudah lewat lebih dari 5 menit.'])
                             ->withInput();
            }
        }

        $endTime = Carbon::parse($request->start_time)->addMinutes((int)$request->duration)->format('H:i');
        
        // Panggil algoritma, pastikan mengecualikan ID jadwal yang sedang diedit
        if (Schedule::isOverlapping($tanggal, $request->start_time, $request->duration, $id)) {
            return back()->withErrors(['start_time' => 'Gagal! Waktu ini bertabrakan dengan jadwal program lain.'])->withInput();
        }

        $schedule->update([
            'program_name' => $request->program_name,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'end_time' => $endTime,
            'date' => $tanggal
        ]);

        return back()->with('success', 'Jadwal diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') { 
            return back()->withErrors(['auth' => 'Akses ditolak.']); 
        }
        
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }
}