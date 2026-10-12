<?php

$file = __DIR__.'/resources/views/home.blade.php';

if (!file_exists($file)) {
    exit("ERROR: home.blade.php tidak ditemukan\n");
}

$source = file_get_contents($file);

if (strpos($source, 'PRIMA HOST V4.4') !== false) {
    exit("V4.4 sudah terpasang.\n");
}

$pattern = '~<a\s+href="\{\{\s*url\(\s*\'/product/\'\s*\.\s*\$product->id\s*\)\s*\}\}"\s+class="btn-detail"\s*>\s*Lihat Detail\s*</a>~s';

$replacement = <<<'BLADE'
<div class="prima-v44-actions">
    <a href="{{ url('/product/'.$product->id) }}"
       class="btn-detail">🔍 Lihat Detail</a>

    @if($product->stock > 0)
        <a href="{{ url('/product/'.$product->id) }}"
           class="prima-v44-cart">🛒 Keranjang</a>
    @else
        <button type="button" class="prima-v44-disabled" disabled>
            Stok Habis
        </button>
    @endif

    <button type="button"
            class="prima-v44-favorite"
            data-product="{{ $product->id }}">
        ♡ Favorit
    </button>
</div>
BLADE;

$updated = preg_replace($pattern, $replacement, $source, -1, $count);

if ($updated === null || $count !== 2) {
    exit("ERROR: Ditemukan $count tombol detail; seharusnya 2. File tidak diubah.\n");
}

$css = <<<'CSS'
/* PRIMA HOST V4.4 */
.prima-v44-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:7px;
    margin-top:10px;
}
.prima-v44-actions .btn-detail{
    grid-column:1/-1;
    margin-top:0;
}
.prima-v44-cart{
    display:block;
    background:#ff6f00;
    color:#fff;
    text-decoration:none;
    text-align:center;
    border-radius:9px;
    padding:10px 5px;
    font-size:12px;
    font-weight:bold;
}
.prima-v44-favorite{
    background:#fff0f2;
    color:#e91e63;
    border:1px solid #ffc2d1;
    border-radius:9px;
    padding:10px 5px;
    font-size:12px;
    font-weight:bold;
    cursor:pointer;
}
.prima-v44-favorite.active{
    background:#e91e63;
    color:#fff;
}
.prima-v44-disabled{
    background:#ddd;
    color:#777;
    border:0;
    border-radius:9px;
    padding:10px 5px;
}
@media(max-width:768px){
    .prima-v44-actions{gap:5px}
    .prima-v44-cart,
    .prima-v44-favorite{
        font-size:11px;
        padding:9px 3px;
    }
}
CSS;

$js = <<<'JS'
<script>
/* PRIMA FAVORIT V4.4 */
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.prima-v44-favorite').forEach(function(btn){
        var key = 'prima_fav_' + btn.dataset.product;

        function refresh(){
            try {
                var active = localStorage.getItem(key) === '1';
                btn.classList.toggle('active', active);
                btn.textContent = active ? '♥ Favorit' : '♡ Favorit';
            } catch(e){}
        }

        refresh();

        btn.addEventListener('click', function(){
            try {
                var active = localStorage.getItem(key) === '1';
                localStorage.setItem(key, active ? '0' : '1');
                refresh();
            } catch(e){}
        });
    });
});
</script>
JS;

if (strpos($updated, '</style>') === false ||
    strpos($updated, '</body>') === false) {
    exit("ERROR: Struktur HTML tidak lengkap. File tidak diubah.\n");
}

$updated = str_replace('</style>', $css."\n</style>", $updated);
$updated = str_replace('</body>', $js."\n</body>", $updated);

$backup = $file.'.backup_v44_'.date('Ymd_His');

if (!copy($file, $backup)) {
    exit("ERROR: Backup gagal. File tidak diubah.\n");
}

if (file_put_contents($file, $updated, LOCK_EX) === false) {
    copy($backup, $file);
    exit("ERROR: Penulisan gagal. Backup dipulihkan.\n");
}

echo "================================\n";
echo " PRIMA HOST V4.4 BERHASIL\n";
echo "================================\n";
echo "Tombol diperbarui: $count\n";
echo "Backup: $backup\n";
echo "Database tidak diubah.\n";
