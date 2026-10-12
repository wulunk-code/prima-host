<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORMAT NOMOR WA
    |--------------------------------------------------------------------------
    */

    private function formatWa($phone)
    {
        $wa = preg_replace('/[^0-9]/', '', $phone);

        if (substr($wa, 0, 1) == '0') {
            $wa = '62' . substr($wa, 1);
        }

        return $wa;
    }

    /*
    |--------------------------------------------------------------------------
    | DATA PESANAN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::latest()->paginate(20);

        return view(
            'admin.pesanan',
            compact('orders')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $order = Order::with('items.product')
            ->findOrFail($id);

        return view(
            'admin.pesanan_detail',
            compact('order')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function verifikasi($id)
    {
        $order = Order::findOrFail($id);

        $order->payment_status = 'lunas';
        $order->status = 'diproses';
        $order->save();

        $wa = $this->formatWa($order->phone);

        $pesan =
            "Halo " .
            $order->customer_name .
            "\n\nPembayaran Invoice " .
            $order->invoice .
            " telah diverifikasi." .
            "\nPesanan sedang diproses.";

        return redirect(
            "https://wa.me/" .
            $wa .
            "?text=" .
            urlencode($pesan)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM KIRIM
    |--------------------------------------------------------------------------
    */

    public function formKirim($id)
    {
        $order = Order::findOrFail($id);

        return view(
            'admin.pengiriman',
            compact('order')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGIRIMAN
    |--------------------------------------------------------------------------
    */

    public function kirim(Request $request, $id)
    {
        $request->validate([
            'kurir' => 'required',
            'resi' => 'required'
        ]);

        $order = Order::findOrFail($id);

        $order->status = 'dikirim';
        $order->kurir = $request->kurir;
        $order->resi = $request->resi;
        $order->save();

        $wa = $this->formatWa($order->phone);

        $pesan =
            "Halo " .
            $order->customer_name .
            "\n\nPesanan telah dikirim." .
            "\nInvoice : " .
            $order->invoice .
            "\nKurir : " .
            $request->kurir .
            "\nResi : " .
            $request->resi;

        return redirect(
            "https://wa.me/" .
            $wa .
            "?text=" .
            urlencode($pesan)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PESANAN SELESAI
    |--------------------------------------------------------------------------
    */

    public function selesai($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'selesai';
        $order->save();

        $setting = Setting::first();

        $wa = $this->formatWa($order->phone);

        $pesan =
            "Terima kasih " .
            $order->customer_name .
            "\n\nPesanan Invoice " .
            $order->invoice .
            " telah selesai." .
            "\n\n" .
            ($setting->store_name ?? 'Toko Kami');

        return redirect(
            "https://wa.me/" .
            $wa .
            "?text=" .
            urlencode($pesan)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BATALKAN PESANAN
    |--------------------------------------------------------------------------
    */

    public function batal($id)
    {
        $order = Order::findOrFail($id);

        $order->status = 'dibatalkan';
        $order->save();

        return back()->with(
            'success',
            'Pesanan dibatalkan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS PESANAN
    |--------------------------------------------------------------------------
    */

    public function hapus($id)
    {
        $order = Order::findOrFail($id);

        OrderItem::where(
            'order_id',
            $order->id
        )->delete();

        $order->delete();

        return back()->with(
            'success',
            'Pesanan berhasil dihapus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INVOICE
    |--------------------------------------------------------------------------
    */

    public function invoice($id)
    {
        $order = Order::with('items.product')
            ->findOrFail($id);

        $setting = Setting::first();

        return view(
            'invoice',
            compact(
                'order',
                'setting'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    public function laporan()
    {
        $orders = Order::where(
            'status',
            'selesai'
        )
        ->latest()
        ->get();

        $totalOmzet = Order::where(
            'status',
            'selesai'
        )
        ->sum('total');

        return view(
            'admin.laporan',
            compact(
                'orders',
                'totalOmzet'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER LAPORAN
    |--------------------------------------------------------------------------
    */

    public function laporanFilter(Request $request)
    {
        $orders = Order::where(
            'status',
            'selesai'
        )
        ->whereDate(
            'created_at',
            '>=',
            $request->tanggal_awal
        )
        ->whereDate(
            'created_at',
            '<=',
            $request->tanggal_akhir
        )
        ->latest()
        ->get();

        $totalOmzet = $orders->sum('total');

        return view(
            'admin.laporan',
            compact(
                'orders',
                'totalOmzet'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT MEMBER
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $orders = Order::latest()->paginate(20);

        return view(
            'member.riwayat',
            compact('orders')
        );
    }
}