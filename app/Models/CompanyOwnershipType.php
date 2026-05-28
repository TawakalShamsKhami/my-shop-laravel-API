<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyOwnershipType extends Model
{
      protected $fillable = [
        'company_id',
        'owner_ship_type_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function ownershipType()
    {
        return $this->belongsTo(OwnershipType::class, 'owner_ship_type_id');
    }
}
