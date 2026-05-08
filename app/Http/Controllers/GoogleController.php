<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
                
                // Catat ke riwayat (created_at otomatis diisi oleh Laravel)
                LoginHistory::create([
                    'user_id'    => $user->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
                
                return $user->role === 'admin' 
                    ? redirect()->intended('/admin/dashboard') 
                    : redirect()->intended('/dashboard');
            }

            return redirect('/')->withErrors(['email' => 'Akses Ditolak: Email Anda belum didaftarkan oleh Administrator.']);

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['email' => 'Terjadi kesalahan saat otentikasi Google. Silakan coba lagi.']); 
        }
    }

    // Pindahkan fungsi logout ke sini karena AuthController sudah dihapus
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}