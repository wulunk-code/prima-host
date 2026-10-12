<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $fillable = [
        'reseller_code',
        'name',
        'phone',
        'email',
        'store_name',
        'address',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'qris_image',
        'commission_balance',
        'is_active'
    ];
}