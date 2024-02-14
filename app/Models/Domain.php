<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $primaryKey = 'PropertyID';
    protected $fillable = ['domain', 'ssl_issuer', 'ssl_expiration_date', 'ssl_is_valid', 'headers', 'php_version'];
    public $incrementing = false;
    

    public function users()
    {
        return $this->belongsToMany(User::class, 'domain_user', 'domain_id', 'user_id');
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'OrganizationID', 'OrganizationID');
    }
}
