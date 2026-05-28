<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
      protected $fillable = [
        'company_id',
        'business_type_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
