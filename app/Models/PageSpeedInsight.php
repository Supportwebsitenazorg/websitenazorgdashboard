<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSpeedInsight extends Model
{
    use HasFactory;

    protected $table = 'page_speed_insights';
    protected $fillable = ['domain', 'mobile_insights', 'desktop_insights'];
    public $timestamps = true;
}
