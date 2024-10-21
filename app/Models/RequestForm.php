<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RequestForm extends Model
{
    use HasFactory;

    // Tentukan tabel yang akan digunakan
    protected $table = 'requests';

    // Jika primary key-nya bukan 'id', sesuaikan di sini
    protected $primaryKey = 'id'; // ganti jika key-nya berbeda

    // Tentukan kolom yang dapat diisi
    protected $fillable = ['name', 'date' , 'category', 'codeOffice', 'description', 'status'];

    protected static function booted()
    {
        static::creating(function ($request) {
            $request->unique_code = uniqid(); // Generate unique code
        });
    }
}