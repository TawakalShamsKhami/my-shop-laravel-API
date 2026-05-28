<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipType extends Model
{
  protected $fillable = [
        'name',
        'status',
        'created_by'
    ];

    // Relationship (optional)
    public function companyOwnershipType()
    {
        return $this->hasMany(CompanyOwnershipType::class);
    }
}
