<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK ANTARA TOKO DAN PELANGGAN
    |--------------------------------------------------------------------------
    */

    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371;

        $lat1 = deg2rad((float) $lat1);
        $lon1 = deg2rad((float) $lon1);
        $lat2 = deg2rad((float) $lat2);
        $lon2 = deg2rad((float) $lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) ** 2
            + cos($lat1)
            * cos($lat2)
            * sin($dLon / 2) ** 2;

        $a = min(1, max(0, $a));

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return round($earth * $c, 2);
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkoutForm()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        $setting = Setting::first();

        return view(
            'checkout',
            compact('cart', 'setting')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES CHECKOUT DAN SIMPAN PESANAN
    |--------------------------------------------------------------------------
    */

    public function checkout(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:30',
            'alamat' => 'required|string|max:2000',
            'metode_pembayaran' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        $setting = Setting::first();

        /*
        |--------------------------------------------------------------------------
        | HITUNG SUBTOTAL DARI KERANJANG
        |--------------------------------------------------------------------------
        |
        | Harga dan jumlah harus valid.
        | Nilai subtotal setiap produk dihitung ulang.
        |
        */

        $subtotal = 0;
        $items = [];

        foreach ($cart as $key => $item) {
            if (
                !isset($item['id']) ||
                !isset($item['name']) ||
                !isset($item['price']) ||
                !isset($item['qty']) ||
                !is_numeric($item['price']) ||
                !is_numeric($item['qty']) ||
                (float) $item['price'] < 0 ||
                (int) $item['qty'] < 1
            ) {
                return redirect('/cart')
                    ->with(
                        'error',
                        'Data keranjang tidak valid. Silakan periksa produk.'
                    );
            }

            $price = round((float) $item['price'], 2);
            $qty = (int) $item['qty'];

            $itemSubtotal = round(
                $price * $qty,
                2
            );

            $subtotal += $itemSubtotal;

            $items[] = [
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $itemSubtotal,
            ];
        }

        $subtotal = round($subtotal, 2);

        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK DAN ONGKOS KIRIM
        |--------------------------------------------------------------------------
        */

        $jarak = 0;
        $ongkir = 0;

        $customerLat = $request->input('latitude');
        $customerLng = $request->input('longitude');

        $storeLat = $setting->latitude ?? null;
        $storeLng = $setting->longitude ?? null;

        $freeRadius = (float) (
            $setting->free_radius ?? 5
        );

        $defaultShipping = (float) (
            $setting->ongkir_default ?? 5000
        );

        /*
         * Ongkir hanya dihitung apabila koordinat pelanggan
         * dan koordinat toko tersedia.
         */

        if (
            $customerLat !== null &&
            $customerLat !== '' &&
            $customerLng !== null &&
            $customerLng !== '' &&
            $storeLat !== null &&
            $storeLat !== '' &&
            $storeLng !== null &&
            $storeLng !== ''
        ) {
            $jarak = $this->distance(
                $storeLat,
                $storeLng,
                $customerLat,
                $customerLng
            );

            if ($jarak > $freeRadius) {
                $ongkir = $defaultShipping;
            }
        }

        $ongkir = round($ongkir, 2);

        /*
        |--------------------------------------------------------------------------
        | TOTAL AKHIR
        |--------------------------------------------------------------------------
        */

        $grandTotal = round(
            $subtotal + $ongkir,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | SIMPAN ORDER DAN ORDER ITEMS
        |--------------------------------------------------------------------------
        |
        | Transaksi memastikan order dan detail produk tersimpan
        | bersama-sama. Jika terjadi kesalahan, perubahan dibatalkan.
        |
        */

        $order = DB::transaction(function () use (
            $request,
            $items,
            $subtotal,
            $ongkir,
            $jarak,
            $grandTotal
        ) {
            /*
             * Gunakan ID berikutnya sebagai bagian nomor invoice.
             * ID unik tetap menjadi identitas utama order.
             */

            $orderId = DB::table('orders')
                ->insertGetId([
                    'invoice' => null,
                    'customer_name' => $request->nama,
                    'phone' => $request->telepon,
                    'address' => $request->alamat,
                    'payment_method' => $request->metode_pembayaran,
                    'payment_status' => 'Pending',
                    'status' => 'Pending',
                    'ongkir' => $ongkir,
                    'jarak' => $jarak,
                    'total' => $grandTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            $invoice = 'PH-'
                . now()->format('Ymd')
                . '-'
                . str_pad(
                    (string) $orderId,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            DB::table('orders')
                ->where('id', $orderId)
                ->update([
                    'invoice' => $invoice,
                    'updated_at' => now(),
                ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return Order::findOrFail($orderId);
        });

        /*
        |--------------------------------------------------------------------------
        | KOSONGKAN KERANJANG
        |--------------------------------------------------------------------------
        */

        session()->forget('cart');

        return redirect()->route(
            'order.detail',
            $order->id
        )->with(
            'success',
            'Pesanan berhasil dibuat.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PESANAN PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $order = Order::with('items')
            ->findOrFail($id);

        $setting = Setting::first();

        return view(
            'order_detail',
            compact('order', 'setting')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD BUKTI TRANSFER
    |--------------------------------------------------------------------------
    */

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'bank' => 'required|string|max:100',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $order = Order::findOrFail($id);

        /*
         * Pesanan yang sudah lunas tidak perlu mengunggah
         * bukti pembayaran ulang.
         */

        if (strtolower($order->payment_status) === 'lunas') {
            return back()->with(
                'error',
                'Pembayaran pesanan ini sudah diverifikasi.'
            );
        }

        /*
         * Simpan file menggunakan nama acak agar nama file
         * dari perangkat pengguna tidak dipakai langsung.
         */

        $directory = public_path('uploads/bukti');

        if (!File::isDirectory($directory)) {
            File::makeDirectory(
                $directory,
                0755,
                true
            );
        }

        $file = $request->file('bukti_transfer');

        $filename = Str::uuid()
            . '.'
            . $file->extension();

        $file->move(
            $directory,
            $filename
        );

        $newPath = 'uploads/bukti/' . $filename;

        try {
            $oldPath = $order->bukti_transfer;

            $order->update([
                'bukti_transfer' => $newPath,
                'sender_name' => $request->sender_name,
                'bank' => $request->bank,
                'payment_status' => 'Menunggu Verifikasi',
                'status' => 'Menunggu Verifikasi',
            ]);

            /*
             * Hapus bukti lama setelah bukti baru berhasil
             * disimpan ke database.
             */

            if (
                $oldPath &&
                $oldPath !== $newPath &&
                strpos($oldPath, 'uploads/bukti/') === 0
            ) {
                $oldFile = public_path($oldPath);

                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
        } catch (\Throwable $e) {
            if (File::exists(public_path($newPath))) {
                File::delete(public_path($newPath));
            }

            throw $e;
        }

        return back()->with(
            'success',
            'Bukti transfer berhasil dikirim dan menunggu verifikasi admin.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK INVOICE
    |--------------------------------------------------------------------------
    */

    public function printInvoice($id)
    {
        $order = Order::with('items')
            ->findOrFail($id);

        $setting = Setting::first();

        return view(
            'invoice_print',
            compact('order', 'setting')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PESANAN
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        $orders = Order::latest()
            ->paginate(20);

        return view(
            'order_history',
            compact('orders')
        );
    }
}