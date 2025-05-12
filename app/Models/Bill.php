<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['customer_id', 'month', 'amount', 'is_paid'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
