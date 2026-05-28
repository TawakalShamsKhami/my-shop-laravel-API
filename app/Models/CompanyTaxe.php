<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTaxe extends Model
{
      protected $fillable = [
        'company_id',
        'tax_id',
        'status',
        'created_by'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function ownershipType()
    {
        return $this->belongsTo(CompanyTaxe::class, 'tax_id');
    }
}
