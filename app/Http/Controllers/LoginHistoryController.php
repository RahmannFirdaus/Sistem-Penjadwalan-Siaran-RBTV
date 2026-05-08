<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $date = $request->query('date');

        $query = LoginHistory::with('user');

        // 1. Fitur Pencarian (Nama atau Email)
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // 2. Fitur Filter Tanggal
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // 3. Fitur Pagination (10 data per halaman)
        $histories = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.history', compact('histories', 'date'));
    }

    // 4. Fitur Export ke CSV
    public function export(Request $request)
    {
        if (Auth::user()->role !== 'admin') { abort(403); }

        $date = $request->query('date');
        $query = LoginHistory::with('user');
        
        if ($date) { $query->whereDate('created_at', $date); }
        
        $logs = $query->orderBy('created_at', 'desc')->get();
        $fileName = "Riwayat_Login_" . ($date ?? 'Semua') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama User', 'Email', 'Role', 'IP Address', 'Waktu Login', 'Perangkat']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->user->name,
                    $log->user->email,
                    $log->user->role,
                    $log->ip_address,
                    Carbon::parse($log->created_at)->format('d-m-Y H:i') . ' WIB',
                    $log->user_agent
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}