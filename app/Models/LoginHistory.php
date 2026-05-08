<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_time'
    ];

    // Relasi ke User (Agar bisa memanggil $log->user->name)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}