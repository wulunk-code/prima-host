<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'reseller_id',
        'order_id',
        'amount',
        'status'
    ];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}