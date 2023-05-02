<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'result',
        'conversion_date',
    ];

    protected $casts = [
        'conversion_date' => 'date',
    ];
}
