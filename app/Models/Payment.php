<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public function order() { return $this->belongsTo(Order::class); }
    public function service() { return $this->belongsTo(Service::class); }
}
