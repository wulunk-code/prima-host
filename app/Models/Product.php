<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'weight',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KATEGORI
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI ORDER ITEM
    |--------------------------------------------------------------------------
    */
    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class,
            'product_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT HARGA
    |--------------------------------------------------------------------------
    */
    public function getHargaAttribute()
    {
        return number_format(
            $this->price,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | URL GAMBAR
    |--------------------------------------------------------------------------
    */
    public function getImageUrlAttribute()
{
    if (!empty($this->image)) {
        return asset($this->image);
    }

    return asset('images/no-image.png');
}
}