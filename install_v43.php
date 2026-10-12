<?php

echo "\n===== PRIMA HOST V4.3 =====\n";

$file = __DIR__.'/resources/views/home.blade.php';

if (!file_exists($file)) {
    exit("ERROR: home.blade.php tidak ditemukan\n");
}

$content = file_get_contents($file);

if (strpos($content, 'prima-v43-actions') !== false) {
    exit("V4.3 sudah terpasang.\n");
}

$pattern = '/(<a\b[^>]*class=["\'][^"\']*\bbtn-detail\b[^"\']*["\'][^>]*>[\s\S]*?<\/a>)/i';

if (!preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
    exit("ERROR: Tombol detail tidak ditemukan.\n");
}

$target = null;

foreach ($matches[0] as $match) {
    $before = substr(
        $content,
        max(0, $match[1] - 600),
        min(600, $match[1])
    );

    if (preg_match('/@if\s*\(\s*\$product->stock\s*>\s*0\s*\)/', $before)) {
        $target = $match;
        break;
    }
}

if (!$target) {
    exit("ERROR: Posisi tombol belum dapat dipastikan.\n");
}

if (strpos($content, '</body>') === false) {
    exit("ERROR: Tag body tidak ditemukan.\n");
}

$buttons = <<<'BLADE'

<!-- PRIMA HOST V4.3 -->
<div class="prima-v43-actions">

<form method="POST"
      action="{{ route('cart.add', $product->id) }}">
    @csrf

    <button type="submit"
            class="prima-v43-cart">
        🛒 + Keranjang
    </button>
</form>

<button type="button"
        class="prima-v43-favorite"
        data-product-id="{{ $product->id }}"
        aria-label="Tambah ke favorit"
        onclick="primaToggleFavorite(this)">
    ♡
</button>

</div>
<!-- END PRIMA HOST V4.3 -->

BLADE;

$position = $target[1] + strlen($target[0]);

$content = substr($content, 0, $position)
         . "\n".$buttons
         . substr($content, $position);

$style = <<<'HTML'

<style id="prima-v43-style">
.prima-v43-actions {
    display: flex;
    align-items: stretch;
    gap: 8px;
    width: 100%;
    margin-top: 10px;
}

.prima-v43-actions form {
    flex: 1;
    min-width: 0;
    margin: 0;
}

.prima-v43-cart {
    width: 100%;
    min-height: 42px;
    padding: 10px 6px;
    border: none;
    border-radius: 10px;
    background: #00b140;
    color: white;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
}

.prima-v43-cart:active {
    background: #008f34;
}

.prima-v43-favorite {
    width: 44px;
    min-width: 44px;
    min-height: 42px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: white;
    color: #ff6600;
    font-size: 25px;
    cursor: pointer;
}

.prima-v43-favorite.active {
    color: #e60023;
    background: #fff0f3;
}

@media(max-width:480px) {
    .prima-v43-actions {
        gap: 5px;
    }

    .prima-v43-cart {
        font-size: 12px;
        padding: 9px 4px;
    }

    .prima-v43-favorite {
        width: 40px;
        min-width: 40px;
    }
}
</style>

HTML;

$javascript = <<<'HTML'

<script id="prima-v43-script">
function primaToggleFavorite(button) {
    let id = String(button.dataset.productId);
    let favorites = [];

    try {
        favorites = JSON.parse(
            localStorage.getItem('prima_favorites') || '[]'
        );

        if (!Array.isArray(favorites)) {
            favorites = [];
        }
    } catch(e) {
        favorites = [];
    }

    if (favorites.includes(id)) {
        favorites = favorites.filter(item => item !== id);
        button.classList.remove('active');
        button.textContent = '♡';
    } else {
        favorites.push(id);
        button.classList.add('active');
        button.textContent = '♥';
    }

    localStorage.setItem(
        'prima_favorites',
        JSON.stringify(favorites)
    );
}

document.addEventListener('DOMContentLoaded', function() {
    let favorites = [];

    try {
        favorites = JSON.parse(
            localStorage.getItem('prima_favorites') || '[]'
        );

        if (!Array.isArray(favorites)) {
            favorites = [];
        }
    } catch(e) {
        favorites = [];
    }

    document.querySelectorAll(
        '.prima-v43-favorite'
    ).forEach(function(button) {
        if (favorites.includes(
            String(button.dataset.productId)
        )) {
            button.classList.add('active');
            button.textContent = '♥';
        }
    });
});
</script>

HTML;

$content = str_replace(
    '</head>',
    $style.'</head>',
    $content
);

$content = str_replace(
    '</body>',
    $javascript.'</body>',
    $content
);

$backup = $file.'.backup_v43_'.date('Ymd_His');

if (!copy($file, $backup)) {
    exit("ERROR: Backup gagal. Tidak ada perubahan.\n");
}

if (file_put_contents($file, $content, LOCK_EX) === false) {
    copy($backup, $file);
    exit("ERROR: Gagal menyimpan. Backup dipulihkan.\n");
}

echo "Backup berhasil dibuat.\n";
echo "Tombol keranjang terpasang.\n";
echo "Tombol favorit terpasang.\n";
echo "CSS responsif terpasang.\n";
echo "JavaScript favorit terpasang.\n";
echo "\n===== INSTALASI V4.3 SELESAI =====\n";
