<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormHosting extends Model
{
    use HasFactory;

    protected $table = 'formhosting';

    protected $fillable = [
        'name',
        'date',
        'category',
        'code_office',
        'description',
        'proof',
        'unique_code',
        'status',
        'reply_message',
        'reply_file_url',
    ];
}
