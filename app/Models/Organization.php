<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrganizationID';
    public $incrementing = false;

    protected $fillable = [
        'organization', 'address', 'zipcode', 'city', 'country', 'vat', 'coc', 'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user', 'organization_id', 'user_id');
    }
}
