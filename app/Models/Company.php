<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'status',
        'licence_number',
        'tin_number',
        'phone',
        'email',
        // 'created_by',
        // 'owner_ship_type_id'
    ];

        public function ownershipTypes()
    {
        return $this->hasMany(CompanyOwnershipType::class);
    }

        public function taxes()
    {
        return $this->hasMany(Taxe::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_users');
    }

}
