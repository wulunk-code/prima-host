<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Daftar produk
Route::get('/produk', [ProductController::class, 'frontend'])
    ->name('produk');

// Detail produk
Route::get('/product/{id}', [ProductController::class, 'show'])
    ->name('product.show');

// Produk berdasarkan kategori
Route::get('/kategori/{id}', function ($id) {

    $products = \App\Models\Product::where(
        'category_id',
        $id
    )->latest()->get();

    $events = \App\Models\Event::latest()->get();

    $promotions = \App\Models\Promotion::latest()->get();

    $setting = \App\Models\Setting::first();

    return view('home', compact(
        'products',
        'events',
        'promotions',
        'setting'
    ));

})->name('kategori');


/*
|--------------------------------------------------------------------------
| CART / KERANJANG
|--------------------------------------------------------------------------
*/

// Lihat keranjang
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

// Tambahkan produk ke keranjang
Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

// Ubah jumlah produk
Route::post('/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

// Hapus produk dari keranjang
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

// Form checkout
Route::get('/checkout', [CheckoutController::class, 'checkoutForm'])
    ->name('checkout.form');

// Simpan pesanan
Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('checkout');

// Detail pesanan pelanggan
Route::get('/pesanan/{id}', [CheckoutController::class, 'detail'])
    ->name('order.detail');

// Upload bukti transfer
Route::post('/upload-bukti/{id}', [CheckoutController::class, 'uploadBukti'])
    ->name('upload.bukti');


/*
|--------------------------------------------------------------------------
| INVOICE
|--------------------------------------------------------------------------
*/

// Halaman invoice
Route::get('/invoice/{id}', [OrderController::class, 'invoice'])
    ->name('invoice');

// Cetak invoice
Route::get('/invoice/{id}/print', [CheckoutController::class, 'printInvoice'])
    ->name('invoice.print');


/*
|--------------------------------------------------------------------------
| RIWAYAT PESANAN
|--------------------------------------------------------------------------
*/

Route::get('/riwayat', [OrderController::class, 'riwayat'])
    ->name('riwayat');


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ORDERS / PESANAN
|--------------------------------------------------------------------------
*/

// Daftar pesanan
Route::get('/admin/orders', [OrderController::class, 'index'])
    ->name('orders.index');

// Detail pesanan admin
Route::get('/admin/orders/{id}', [OrderController::class, 'detail'])
    ->name('orders.detail');

// Verifikasi pembayaran
Route::post('/admin/orders/verifikasi/{id}', [OrderController::class, 'verifikasi'])
    ->name('orders.verifikasi');

// Form pengiriman
Route::get('/admin/orders/kirim/{id}', [OrderController::class, 'formKirim'])
    ->name('orders.kirim.form');

// Simpan data pengiriman
Route::post('/admin/orders/kirim/{id}', [OrderController::class, 'kirim'])
    ->name('orders.kirim');

// Tandai pesanan selesai
Route::post('/admin/orders/selesai/{id}', [OrderController::class, 'selesai'])
    ->name('orders.selesai');

// Batalkan pesanan
Route::post('/admin/orders/batal/{id}', [OrderController::class, 'batal'])
    ->name('orders.batal');

// Hapus pesanan
Route::post('/admin/orders/delete/{id}', [OrderController::class, 'hapus'])
    ->name('orders.delete');


/*
|--------------------------------------------------------------------------
| LAPORAN OMZET
|--------------------------------------------------------------------------
*/

// Laporan pesanan selesai
Route::get('/admin/laporan', [OrderController::class, 'laporan'])
    ->name('laporan');

// Filter laporan
Route::post('/admin/laporan/filter', [OrderController::class, 'laporanFilter'])
    ->name('laporan.filter');


/*
|--------------------------------------------------------------------------
| ADMIN PRODUCTS / PRODUK
|--------------------------------------------------------------------------
*/

// Daftar produk
Route::get('/admin/products', [ProductController::class, 'index'])
    ->name('products.index');

// Form tambah produk
Route::get('/admin/products/create', [ProductController::class, 'create'])
    ->name('products.create');

// Simpan produk
Route::post('/admin/products/store', [ProductController::class, 'store'])
    ->name('products.store');

// Form edit produk
Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])
    ->name('products.edit');

// Simpan perubahan produk
Route::post('/admin/products/update/{id}', [ProductController::class, 'update'])
    ->name('products.update');

// Hapus produk
Route::get('/admin/products/delete/{id}', [ProductController::class, 'destroy'])
    ->name('products.delete');


/*
|--------------------------------------------------------------------------
| ADMIN MEMBERS
|--------------------------------------------------------------------------
*/

// Daftar member
Route::get('/admin/members', [MemberController::class, 'index'])
    ->name('members.index');

// Form tambah member
Route::get('/admin/members/create', [MemberController::class, 'create'])
    ->name('members.create');

// Simpan member
Route::post('/admin/members/store', [MemberController::class, 'store'])
    ->name('members.store');

// Hapus member
Route::get('/admin/members/delete/{id}', [MemberController::class, 'destroy'])
    ->name('members.delete');


/*
|--------------------------------------------------------------------------
| ADMIN PROMOTIONS / PROMOSI
|--------------------------------------------------------------------------
*/

// Daftar promosi
Route::get('/admin/promotions', [PromotionController::class, 'index'])
    ->name('promotions.index');

// Form tambah promosi
Route::get('/admin/promotions/create', [PromotionController::class, 'create'])
    ->name('promotions.create');

// Simpan promosi
Route::post('/admin/promotions/store', [PromotionController::class, 'store'])
    ->name('promotions.store');

// Hapus promosi
Route::get('/admin/promotions/delete/{id}', [PromotionController::class, 'destroy'])
    ->name('promotions.delete');


/*
|--------------------------------------------------------------------------
| ADMIN EVENTS / ACARA
|--------------------------------------------------------------------------
*/

// Daftar acara
Route::get('/admin/events', [EventController::class, 'index'])
    ->name('events.index');

// Form tambah acara
Route::get('/admin/events/create', [EventController::class, 'create'])
    ->name('events.create');

// Simpan acara
Route::post('/admin/events/store', [EventController::class, 'store'])
    ->name('events.store');

// Hapus acara
Route::get('/admin/events/delete/{id}', [EventController::class, 'destroy'])
    ->name('events.delete');


/*
|--------------------------------------------------------------------------
| ADMIN SETTINGS / PENGATURAN TOKO
|--------------------------------------------------------------------------
*/

// Halaman pengaturan toko
Route::get('/admin/settings', [SettingController::class, 'index'])
    ->name('settings.index');

// Simpan pengaturan toko
Route::post('/admin/settings/update', [SettingController::class, 'update'])
    ->name('settings.update');


/*
|--------------------------------------------------------------------------
| ADMIN CATEGORIES / KATEGORI
|--------------------------------------------------------------------------
*/

// Daftar kategori
Route::get('/admin/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

// Form tambah kategori
Route::get('/admin/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create');

// Simpan kategori
Route::post('/admin/categories/store', [CategoryController::class, 'store'])
    ->name('categories.store');

// Hapus kategori
Route::get('/admin/categories/delete/{id}', [CategoryController::class, 'destroy'])
    ->name('categories.delete');