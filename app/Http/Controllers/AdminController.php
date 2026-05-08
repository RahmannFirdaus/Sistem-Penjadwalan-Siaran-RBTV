<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today('Asia/Jakarta')->toDateString();
        $now = Carbon::now('Asia/Jakarta')->format('H:i:s');

        return view('admin.dashboard', [
            'totalProgram'  => Schedule::count(),
            'siaranHariIni' => Schedule::whereDate('date', $today)->count(),
            'totalStaf'     => User::where('role', 'staf')->count(),
            'jadwalTerdekat'=> Schedule::whereDate('date', $today)
                                ->where('start_time', '>', $now)
                                ->orderBy('start_time', 'asc')
                                ->take(4)
                                ->get()
        ]);
    }
}