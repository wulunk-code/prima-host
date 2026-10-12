<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Member;
use App\Models\Promotion;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN PRIMA HOUSE
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $totalMembers = Member::count();

        $totalPromotions = Promotion::count();

        $totalEvents = Event::count();


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI STATUS PESANAN
        |--------------------------------------------------------------------------
        |
        | LOWER() membuat pencarian status tidak bergantung pada
        | penggunaan huruf besar atau huruf kecil.
        |
        */

        $pending = Order::whereRaw(
            'LOWER(status) = ?',
            ['pending']
        )->count();

        $verifikasi = Order::whereRaw(
            'LOWER(status) = ?',
            ['menunggu_verifikasi']
        )->count();

        $diproses = Order::whereRaw(
            'LOWER(status) = ?',
            ['diproses']
        )->count();

        $dikirim = Order::whereRaw(
            'LOWER(status) = ?',
            ['dikirim']
        )->count();

        $selesai = Order::whereRaw(
            'LOWER(status) = ?',
            ['selesai']
        )->count();

        $dibatalkan = Order::whereRaw(
            'LOWER(status) = ?',
            ['dibatalkan']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL OMZET
        |--------------------------------------------------------------------------
        |
        | Hanya menghitung pesanan yang statusnya selesai.
        |
        */

        $totalRevenue = Order::whereRaw(
            'LOWER(status) = ?',
            ['selesai']
        )->sum('total');


        /*
        |--------------------------------------------------------------------------
        | STATISTIK KOMPATIBILITAS
        |--------------------------------------------------------------------------
        |
        | Variabel berikut dipertahankan agar tetap kompatibel
        | dengan dashboard Blade yang sudah ada.
        |
        */

        $pendingOrders = $pending;

        $processingOrders = $diproses;

        $shippingOrders = $dikirim;

        $completedOrders = $selesai;


        /*
        |--------------------------------------------------------------------------
        | PESANAN TERBARU
        |--------------------------------------------------------------------------
        */

        $latestOrders = Order::latest()
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMBAYARAN MENUNGGU VERIFIKASI
        |--------------------------------------------------------------------------
        |
        | Menggunakan payment_status karena status pesanan
        | dan status pembayaran merupakan dua hal berbeda.
        |
        */

        $pendingPayments = Order::whereRaw(
            'LOWER(payment_status) = ?',
            ['menunggu_verifikasi']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK PESANAN 7 HARI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $orderChart = Order::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where(
                'created_at',
                '>=',
                now()->subDays(6)->startOfDay()
            )
            ->groupBy(
                DB::raw('DATE(created_at)')
            )
            ->orderBy('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'totalOrders',
                'totalMembers',
                'totalPromotions',
                'totalEvents',

                'totalRevenue',

                'pendingOrders',
                'processingOrders',
                'shippingOrders',
                'completedOrders',

                'pending',
                'verifikasi',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',

                'pendingPayments',

                'latestOrders',

                'orderChart'
            )
        );
    }
}