<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The domains that belong to the user.
     */
    public function domains()
    {
        return $this->belongsToMany(Domain::class, 'domain_user', 'user_id', 'domain_id');
    }

    /**
     * The organizations that belong to the user.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user', 'user_id', 'organization_id');
    }

    /**
     * Assign the 'orgadmin' role to the user.
     */
    public function assignOrgAdminRole()
    {
        if ($this->role !== 'orgadmin') {
            $this->role = 'orgadmin';
            $this->save();
        }
    }
}
