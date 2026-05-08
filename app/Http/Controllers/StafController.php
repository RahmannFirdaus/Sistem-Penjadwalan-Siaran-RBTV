<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StafController extends Controller
{
    public function index()
    {
        // PERBAIKAN 1: Hapus filter 'where' agar semua user (Admin & Staf) tampil di tabel
        $staf = User::orderBy('created_at', 'desc')->get();
        return view('admin.staf.index', compact('staf'));
    }

    public function store(Request $request)
    {
        // PERBAIKAN 2: Tambahkan validasi role
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staf', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // PERBAIKAN 3: Ambil nilai role dari inputan form
            'password' => Hash::make(Str::random(16)), // Password acak karena login via Google
        ]);

        return back()->with('success', 'Akun berhasil ditambahkan dan di-whitelist!');
    }

    public function update(Request $request, $id)
        {
            // PENGAMAN: Cegah edit akun sendiri
            if ($id == auth()->user()->id) {
                return back()->withErrors(['error' => 'Sistem menolak: Demi keamanan, Anda tidak diizinkan mengedit akun Anda sendiri saat sedang login.']);
            }

            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$id,
                'role' => 'required|in:admin,staf',
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            return back()->with('success', 'Data akun berhasil diperbarui!');
        }

    public function destroy($id)
    {
        if ($id == auth()->user()->id) {
            return back()->withErrors(['error' => 'Sistem menolak: Anda tidak dapat menghapus akun Anda sendiri saat sedang login!']);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akses berhasil dicabut dan data dihapus.');
    }
}