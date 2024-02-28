<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonData extends Model
{
    use HasFactory;

    protected $table = 'carbon';
    protected $fillable = ['domain', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
