<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'invoice',
        'customer_name',
        'phone',
        'address',

        'payment_method',
        'payment_status',
        'status',

        'total',
        'ongkir',
        'jarak',

        'sender_name',
        'bank',
        'bukti_transfer',

        'kurir',
        'resi'
    ];

    protected $casts = [
        'total'  => 'decimal:2',
        'ongkir' => 'decimal:2',
        'jarak'  => 'decimal:2'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI ITEM PESANAN
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL QTY
    |--------------------------------------------------------------------------
    */

    public function getTotalQtyAttribute()
    {
        return $this->items->sum('qty');
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT TOTAL
    |--------------------------------------------------------------------------
    */

    public function getGrandTotalAttribute()
    {
        return number_format(
            $this->total,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function isPaid()
    {
        return $this->payment_status === 'lunas';
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS SELESAI
    |--------------------------------------------------------------------------
    */

    public function isCompleted()
    {
        return strtolower($this->status)
            === 'selesai';
    }

    /*
    |--------------------------------------------------------------------------
    | LABEL STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {

            case 'pending':
                return 'Pending';

            case 'menunggu_verifikasi':
                return 'Menunggu Verifikasi';

            case 'diproses':
                return 'Diproses';

            case 'dikirim':
                return 'Dikirim';

            case 'selesai':
                return 'Selesai';

            case 'batal':
                return 'Dibatalkan';

            default:
                return ucfirst($this->status);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | WARNA BADGE STATUS
    |--------------------------------------------------------------------------
    */

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {

            case 'pending':
                return 'warning';

            case 'menunggu_verifikasi':
                return 'info';

            case 'diproses':
                return 'primary';

            case 'dikirim':
                return 'success';

            case 'selesai':
                return 'dark';

            case 'batal':
                return 'danger';

            default:
                return 'secondary';
        }
    }
}