<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSpeedInsightHistory extends Model
{
    use HasFactory;

    protected $fillable = ['domain', 'date', 'mobile_insights', 'desktop_insights'];

    protected $casts = [
        'mobile_insights' => 'array',
        'desktop_insights' => 'array',
    ];

}
