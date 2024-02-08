<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $primaryKey = 'PropertyID';
    public $incrementing = false;

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'domain_user', 'domain_id', 'user_id');
    }
    
    

}
