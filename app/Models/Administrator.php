<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $table = 'administrator'; // Nama tabel
    protected $fillable = [
        'name',
        'date',
        'category',
        'codeOffice',
        'description',
        'unique_code',
        'status',
        'proof',
    ];
}