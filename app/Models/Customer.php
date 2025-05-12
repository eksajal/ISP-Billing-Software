<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_id',
        'phone',
        'address',
        'package_id',
        'starting_date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
