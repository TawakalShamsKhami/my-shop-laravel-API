<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
   protected $fillable = ['name', 'status', 'address', 'company_id', 'branch_id', 'created_by'];
    public function company() { return $this->belongsTo(Company::class); }
}
