<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'minimum_order',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active'
    ];
}