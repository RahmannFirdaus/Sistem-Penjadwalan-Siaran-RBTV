<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Divisi [cite: 7]
        $prog = Division::create(['name' => 'Program']);
        $redaksi = Division::create(['name' => 'Redaksi']);

        // Akun Admin [cite: 4]
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'division_id' => $prog->id,
            'role' => 'admin',
        ]);

        // Akun Staf Divisi Program (Bisa CRUD Jadwal) [cite: 8]
        User::create([
            'name' => 'Staf Program',
            'username' => 'program',
            'password' => Hash::make('password'),
            'division_id' => $prog->id,
            'role' => 'staff',
        ]);
    }
}

