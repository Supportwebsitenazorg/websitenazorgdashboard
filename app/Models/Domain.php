<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $primaryKey = 'PropertyID';
    public $incrementing = false;

    /**
     * The users that are assigned to the domain.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'domain_user', 'domain_id', 'user_id');
    }
    
    /**
     * The organization that the domain belongs to.
     */
    public function organization()
    {
        // This assumes that there is an 'OrganizationID' column on the 'domains' table.
        // Replace 'OrganizationID' with the correct column name if it is different.
        return $this->belongsTo(Organization::class, 'OrganizationID', 'OrganizationID');
    }

    // You can add additional model methods and relationships here as needed.
}
