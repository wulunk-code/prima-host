<?php

/*
|--------------------------------------------------------------------------
| PRIMA HOUSE MARKETPLACE V4
|--------------------------------------------------------------------------
| Upgrade tampilan produk tanpa mengubah database.
|--------------------------------------------------------------------------
*/

$root = __DIR__;

$view = $root . '/resources/views/home.blade.php';
$css  = $root . '/public/css/prima-marketplace-v4.css';
$js   = $root . '/public/js/prima-marketplace-v4.js';

echo "\n====================================\n";
echo " PRIMA HOUSE MARKETPLACE V4\n";
echo "====================================\n\n";

if (!file_exists($view)) {
    exit("ERROR: home.blade.php tidak ditemukan.\n");
}

if (!is_dir(dirname($css))) {
    mkdir(dirname($css), 0755, true);
}

if (!is_dir(dirname($js))) {
    mkdir(dirname($js), 0755, true);
}

/*
|--------------------------------------------------------------------------
| BACKUP
|--------------------------------------------------------------------------
*/

$backup = $view . '.backup_v4_' . date('Ymd_His');

if (!copy($view, $backup)) {
    exit("ERROR: Gagal membuat backup.\n");
}

echo "Backup berhasil:\n$backup\n\n";

$html = file_get_contents($view);

if ($html === false) {
    exit("ERROR: Gagal membaca halaman.\n");
}

/*
|--------------------------------------------------------------------------
| CSS
|--------------------------------------------------------------------------
*/

$style = <<<'CSS'

/* =====================================
   PRIMA HOUSE MARKETPLACE V4
===================================== */

.product-card {
    position:relative;
    overflow:hidden;
    transition:transform .25s ease,
               box-shadow .25s ease;
}

.product-card:hover {
    transform:translateY(-3px);
    box-shadow:0 8px 24px rgba(0,0,0,.12);
}

/* FAVORIT */

.prima-favorite {
    position:absolute;
    top:10px;
    right:10px;
    z-index:30;

    width:34px;
    height:34px;

    border:0;
    border-radius:50%;

    background:rgba(255,255,255,.95);
    color:#777;

    display:flex;
    align-items:center;
    justify-content:center;

    box-shadow:0 2px 10px rgba(0,0,0,.15);
    cursor:pointer;
}

.prima-favorite i {
    font-size:17px;
}

.prima-favorite.active {
    color:#ff3b30;
}

/* ACTION */

.prima-actions {
    display:flex;
    gap:8px;
    margin-top:auto;
    padding-top:10px;
}

.prima-actions .btn-detail {
    flex:1;
    margin-top:0;
    min-width:0;
}

.prima-cart {
    width:42px;
    min-width:42px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#fff3e8;
    color:#ff6600;

    border:1px solid #ffd4b3;
    border-radius:12px;

    text-decoration:none;
}

.prima-cart i {
    font-size:17px;
}

/* BADGE DISKON */

.prima-discount {
    position:absolute;
    top:48px;
    left:10px;
    z-index:20;

    background:#ff3b30;
    color:white;

    padding:5px 8px;
    border-radius:8px;

    font-size:11px;
    font-weight:700;
}

/* HARGA LAMA */

.prima-old-price {
    color:#999;
    font-size:11px;
    text-decoration:line-through;
    margin-top:4px;
}

/* NOTIFIKASI */

.prima-toast {
    position:fixed;
    left:50%;
    bottom:85px;
    transform:translateX(-50%);

    background:#222;
    color:white;

    padding:11px 18px;
    border-radius:30px;

    font-size:12px;
    white-space:nowrap;

    z-index:10000;
    box-shadow:0 5px 20px rgba(0,0,0,.2);
}

/* MOBILE */

@media(max-width:768px) {

    .prima-favorite {
        width:30px;
        height:30px;
        top:8px;
        right:8px;
    }

    .prima-favorite i {
        font-size:15px;
    }

    .prima-actions {
        gap:6px;
    }

    .prima-cart {
        width:36px;
        min-width:36px;
        border-radius:10px;
    }

    .prima-cart i {
        font-size:15px;
    }

    .prima-actions .btn-detail {
        font-size:11px;
        padding:10px 4px;
    }

}

CSS;

if (file_put_contents($css, $style) === false) {
    exit("ERROR: Gagal menulis CSS.\n");
}

/*
|--------------------------------------------------------------------------
| JAVASCRIPT FAVORIT
|--------------------------------------------------------------------------
*/

$javascript = <<<'JS'

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.prima-favorite').forEach(function(button) {

        const productId = button.dataset.product;

        const key = 'prima_favorite_' + productId;

        if (localStorage.getItem(key) === '1') {
            button.classList.add('active');
        }

        button.addEventListener('click', function() {

            const active = button.classList.toggle('active');

            if (active) {
                localStorage.setItem(key, '1');
                primaToast('❤️ Produk ditambahkan ke favorit');
            } else {
                localStorage.removeItem(key);
                primaToast('Favorit dihapus');
            }

        });

    });

});

function primaToast(message) {

    const old = document.querySelector('.prima-toast');

    if (old) old.remove();

    const toast = document.createElement('div');

    toast.className = 'prima-toast';
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(function() {
        toast.remove();
    }, 2200);

}

JS;

if (file_put_contents($js, $javascript) === false) {
    exit("ERROR: Gagal menulis JavaScript.\n");
}

/*
|--------------------------------------------------------------------------
| TAMBAHKAN CSS DAN JS
|--------------------------------------------------------------------------
*/

$cssTag = <<<'BLADE'
<link rel="stylesheet" href="{{ asset('css/prima-marketplace-v4.css') }}?v=4">
BLADE;

$jsTag = <<<'BLADE'
<script src="{{ asset('js/prima-marketplace-v4.js') }}?v=4" defer></script>
BLADE;

if (strpos($html, 'prima-marketplace-v4.css') === false) {

    if (strpos($html, '</head>') === false) {
        exit("ERROR: Tag </head> tidak ditemukan.\n");
    }

    $html = str_replace(
        '</head>',
        $cssTag . "\n</head>",
        $html
    );
}

if (strpos($html, 'prima-marketplace-v4.js') === false) {

    if (strpos($html, '</body>') === false) {
        exit("ERROR: Tag </body> tidak ditemukan.\n");
    }

    $html = str_replace(
        '</body>',
        $jsTag . "\n</body>",
        $html
    );
}

/*
|--------------------------------------------------------------------------
| TAMBAHKAN FAVORIT DAN AKSI PRODUK
|--------------------------------------------------------------------------
|
| Hanya memproses kartu yang memiliki tautan detail produk.
| Kartu terlaris tanpa tautan detail tidak diubah.
|
|--------------------------------------------------------------------------
*/

$pattern = '~<div class="product-card">.*?</div>\s*</div>~s';

$updated = 0;

$html = preg_replace_callback($pattern, function($matches) use (&$updated) {

    $card = $matches[0];

    if (strpos($card, "url('/product/'.$product->id)") === false) {
        return $card;
    }

    if (strpos($card, 'prima-favorite') !== false) {
        return $card;
    }

    $favorite = <<<'BLADE'

<button type="button"
        class="prima-favorite"
        data-product="{{ $product->id }}"
        aria-label="Simpan favorit">
    <i class="fas fa-heart"></i>
</button>

BLADE;

    $card = preg_replace(
        '~(<div class="product-card">)~',
        '$1' . "\n" . $favorite,
        $card,
        1
    );

    /*
     * Mengubah tautan detail menjadi dua tombol.
     * Tombol keranjang tetap menuju halaman detail.
     */

    $detailPattern = '~<a\s+href="\{\{\s*url\(\'/product/\'\.\$product->id\)\s*\}\}"\s+class="btn-detail">\s*Lihat Detail\s*</a>~s';

    $replacement = <<<'BLADE'
<div class="prima-actions">
    <a href="{{ url('/product/'.$product->id) }}"
       class="btn-detail">
        Lihat Detail
    </a>

    <a href="{{ url('/product/'.$product->id) }}"
       class="prima-cart"
       aria-label="Pesan produk">
        <i class="fas fa-shopping-cart"></i>
    </a>
</div>
BLADE;

    $card = preg_replace(
        $detailPattern,
        $replacement,
        $card,
        1
    );

    $updated++;

    return $card;

}, $html);

/*
|--------------------------------------------------------------------------
| SIMPAN
|--------------------------------------------------------------------------
*/

if (file_put_contents($view, $html) === false) {
    exit("ERROR: Gagal menyimpan Blade.\n");
}

echo "CSS V4 berhasil dibuat.\n";
echo "JavaScript V4 berhasil dibuat.\n";
echo "Kartu yang diproses: $updated\n";

if ($updated === 0) {
    echo "PERINGATAN: Tidak ada kartu yang cocok. Periksa Blade.\n";
}

echo "\n====================================\n";
echo " MARKETPLACE V4 SELESAI\n";
echo "====================================\n";

