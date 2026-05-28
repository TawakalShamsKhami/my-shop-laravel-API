<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
   public function order() { return $this->belongsTo(Order::class); }
    public function stock() { return $this->belongsTo(StockRegistration::class, 'stock_registration_id'); }
}
