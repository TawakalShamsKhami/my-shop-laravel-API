<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
      protected $fillable = [
        'name',
        'status', 
        'address', 
        'phone', 
        'email', 
        'company_id', 
        'created_by'
        ];
}
