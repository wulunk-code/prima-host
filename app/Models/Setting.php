<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [

        // INFORMASI TOKO
        'store_name',
        'store_logo',
        'store_address',
        'store_phone',
        'store_email',

        // REKENING
        'bank_name',
        'account_name',
        'account_number',

        // QRIS
        'qris_image',

        // ONGKIR
        'free_shipping_radius',
        'shipping_fee',

        // LOKASI TOKO
        'latitude',
        'longitude',

        // SOSIAL MEDIA
        'facebook',
        'instagram',
        'youtube',

        // STATUS
        'is_active'
    ];

    protected $casts = [

        'free_shipping_radius' => 'integer',
        'shipping_fee' => 'integer',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | NOMOR WA ADMIN FORMAT 62
    |--------------------------------------------------------------------------
    */
    public function getWhatsappAttribute()
    {
        $wa = preg_replace(
            '/[^0-9]/',
            '',
            $this->store_phone
        );

        if (substr($wa, 0, 1) == '0') {
            $wa = '62' . substr($wa, 1);
        }

        return $wa;
    }

    /*
    |--------------------------------------------------------------------------
    | CEK QRIS
    |--------------------------------------------------------------------------
    */
    public function hasQris()
    {
        return !empty($this->qris_image);
    }

    /*
    |--------------------------------------------------------------------------
    | CEK ONGKIR GRATIS
    |--------------------------------------------------------------------------
    */
    public function isFreeShipping($distance)
    {
        return $distance <=
            ($this->free_shipping_radius ?? 5);
    }
}