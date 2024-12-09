<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan
    protected $table = 'pengguna';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'role',
        'last_active',
        'active',
    ];

    // Tentukan jenis data untuk atribut tertentu (opsional)
    protected $casts = [
        'last_active' => 'datetime',
        'active' => 'boolean',
    ];
}
