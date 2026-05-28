<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRegistration extends Model
{
   protected $table = 'stock_registration';
    public function unit() { return $this->belongsTo(Unit::class); }
    public function definition() { return $this->belongsTo(StockDefinition::class); }
}
