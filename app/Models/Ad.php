<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'url', 'position', 'status', 'start_date', 'end_date'
    ];
}
