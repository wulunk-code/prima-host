from pathlib import Path
from datetime import datetime
import re
import shutil

home = Path("resources/views/home.blade.php")

if not home.exists():
    raise SystemExit("ERROR: home.blade.php tidak ditemukan")

source = home.read_text()
marker = "PRIMA HOST V4.4"

if marker in source:
    raise SystemExit("V4.4 sudah terpasang.")

# Backup
backup = home.with_name(
    "home.blade.php.backup_v44_" +
    datetime.now().strftime("%Y%m%d_%H%M%S")
)
shutil.copy2(home, backup)
print("Backup:", backup)

# Tambahkan CSS
css = """
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
    background:#ff6f00;
    color:white;
    border:0;
    border-radius:9px;
    padding:10px 5px;
    font-size:12px;
    font-weight:bold;
    cursor:pointer;
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
    color:white;
}
.prima-v44-disabled{
    grid-column:1/-1;
    background:#ddd;
    color:#777;
    border:0;
    padding:11px;
    border-radius:9px;
}
@media(max-width:768px){
    .prima-v44-actions{
        gap:5px;
    }
    .prima-v44-cart,
    .prima-v44-favorite{
        font-size:11px;
        padding:9px 3px;
    }
}
"""

if "</style>" not in source:
    raise SystemExit("ERROR: Penutup style tidak ditemukan")

source = source.replace(
    "</style>",
    css + "\n</style>",
    1
)

# Tombol favorit disimpan di browser
js = """
<script>
/* PRIMA HOST V4.4 */
document.addEventListener('DOMContentLoaded',function(){

document.querySelectorAll('.prima-v44-favorite').forEach(function(btn){

    var id=btn.dataset.product;

    try {
        if(localStorage.getItem('prima_fav_'+id)==='1'){
            btn.classList.add('active');
            btn.innerHTML='♥ Favorit';
        }
    } catch(e){}

    btn.addEventListener('click',function(){

        var active=btn.classList.toggle('active');

        btn.innerHTML=active?'♥ Favorit':'♡ Favorit';

        try {
            localStorage.setItem(
                'prima_fav_'+id,
                active?'1':'0'
            );
        } catch(e){}

    });

});

});
</script>
"""

# Ganti tombol detail di bagian Produk Unggulan dan Terbaru
pattern = re.compile(
    r'<a\s+href="\{\{\s*url\('
    r"'/product/'\.\$product->id"
    r'\)\s*\}\}"\s+class="btn-detail">\s*'
    r'Lihat Detail\s*</a>',
    re.S
)

replacement = """
<div class="prima-v44-actions">

    <a href="{{ url('/product/'.$product->id) }}"
       class="btn-detail">
        🔍 Lihat Detail
    </a>

    @if($product->stock > 0)
    <button type="button"
            class="prima-v44-cart"
            onclick="window.location.href='{{ url('/product/'.$product->id) }}'">
        🛒 Keranjang
    </button>
    @else
    <button class="prima-v44-disabled" disabled>
        Stok Habis
    </button>
    @endif

    <button type="button"
            class="prima-v44-favorite"
            data-product="{{ $product->id }}">
        ♡ Favorit
    </button>

</div>
"""

source, count = pattern.subn(
    lambda match: replacement,
    source
)

if count != 2:
    print("ERROR: Ditemukan",count,"tombol, seharusnya 2")
    print("File asli tidak diubah.")
    raise SystemExit(1)

source = source.replace(
    "</body>",
    js + "\n</body>",
    1
)

home.write_text(source)

print("==============================")
print(" PRIMA HOST V4.4 TERPASANG")
print("==============================")
print("Tombol diperbarui:",count)
print("Backup:",backup)
print("Selesai.")
