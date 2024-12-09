<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';
    // Tentukan kolom yang bisa diisi massal (mass assignable)
    protected $fillable = [
        'name',
        'date',
        'category',
        'description',
        'upload_file_path',
        'unique_code',
        'status',
        'reply_message',
        'reply_file_url',
    ];
    
}
