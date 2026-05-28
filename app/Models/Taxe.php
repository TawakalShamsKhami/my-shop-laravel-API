<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    protected $fillable = [
        'name',
        'status',
        'tax_rate',
        'created_by'
    ];

    public function companyTaxe() { return $this->hasMany(companyTaxe::class); }

}
