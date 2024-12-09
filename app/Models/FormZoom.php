<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormZoom extends Model
{
    use HasFactory;

    protected $table = 'form_zoom';

    protected $fillable = [
        'name',
        'date',
        'category',
        'code_office',
        'description',
        'file_path',
        'status',
        'reply_message',
        'reply_file_url',
    ];
}