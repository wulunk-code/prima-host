<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_code',
        'name',
        'phone',
        'email',
        'address',
        'level',
        'points',
        'join_date',
        'expired_date',
        'is_active'
    ];
}