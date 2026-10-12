from pathlib import Path
import re
import shutil
from datetime import datetime

print("===================================")
print(" INSTALL PRIMA HOUSE V4.3")
print("===================================")

home = Path("resources/views/home.blade.php")
css = Path("public/css/prima-marketplace-v4.css")

if not home.exists():
    raise SystemExit("ERROR: home.blade.php tidak ditemukan")

if not css.exists():
    raise SystemExit("ERROR: File CSS tidak ditemukan")

html = home.read_text()

if "prima-v43-actions" in html:
    raise SystemExit("V4.3 sudah terpasang. Tidak ada perubahan.")

# Pastikan struktur kartu sesuai pemeriksaan sebelumnya
cards = re.findall(
    r'<div\s+class=["\']product-card["\']',
    html
)

if len(cards) != 3:
    raise SystemExit(
        f"ERROR: Ditemukan {len(cards)} template kartu, "
        "seharusnya 3. Instalasi dibatalkan."
    )

# Pastikan rute keranjang tersedia
routes = Path("routes/web.php").read_text()

if "cart/add" not in routes:
    raise SystemExit(
        "ERROR: Rute keranjang tidak ditemukan."
    )

# Backup
timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")

shutil.copy2(
    home,
    str(home) + ".backup-v43-" + timestamp
)

shutil.copy2(
    css,
    str(css) + ".backup-v43-" + timestamp
)

print("Backup berhasil dibuat.")

# Tambahkan aksi pada tiap kartu tanpa menghapus detail
action_template = """
<div class="prima-v43-actions">

    <button
        type="button"
        class="prima-v43-favorite"
        data-product-id="{{ PRODUCT_ID }}"
        onclick="primaV43Favorite(this)"
        aria-label="Tambah ke favorit">
        ♡ Favorit
    </button>

    <form
        method="POST"
        action="{{ CART_URL }}"
        class="prima-v43-cart-form">

        @csrf

        <input
            type="hidden"
            name="quantity"
            value="1">

        <button
            type="submit"
            class="prima-v43-cart-btn"
            @if(PRODUCT_STOCK <= 0) disabled @endif>

            @if(PRODUCT_STOCK > 0)
                🛒 + Keranjang
            @else
                Stok Habis
            @endif

        </button>

    </form>

</div>
"""

def build_actions(variable):
    return (
        action_template
        .replace(
            "{{ PRODUCT_ID }}",
            "{{ $" + variable + "->id }}"
        )
        .replace(
            "{{ CART_URL }}",
            "{{ url('/cart/add/'.$" + variable + "->id) }}"
        )
        .replace(
            "PRODUCT_STOCK",
            "$" + variable + "->stock"
        )
    )

# Cari setiap template kartu produk dan tautan detailnya
pattern = re.compile(
    r'(<div\s+class=["\']product-card["\'][^>]*>)'
)

matches = list(pattern.finditer(html))
insertions = []

for index, match in enumerate(matches):
    start = match.end()

    if index + 1 < len(matches):
        end = matches[index + 1].start()
    else:
        end = min(len(html), start + 10000)

    section = html[start:end]

    if "$item->product" in section and index == 0:
        variable = "item->product"
    else:
        variable = "product"

    detail = re.search(
        r'<a\b[^>]*class=["\']btn-detail["\'][^>]*>.*?</a>',
        section,
        re.S
    )

    if not detail:
        raise SystemExit(
            f"ERROR: Tombol detail kartu {index+1} "
            "tidak ditemukan. Instalasi dibatalkan."
        )

    position = start + detail.end()

    insertions.append(
        (position, build_actions(variable))
    )

for position, content in reversed(insertions):
    html = html[:position] + content + html[position:]

# JavaScript favorit lokal
script = """
<script>
function primaV43Favorite(button) {
    const id = button.dataset.productId;
    const key = 'prima_house_favorites_v43';

    let favorites = [];

    try {
        favorites = JSON.parse(
            localStorage.getItem(key) || '[]'
        );
        if (!Array.isArray(favorites)) favorites = [];
    } catch (e) {
        favorites = [];
    }

    const productId = String(id);

    if (favorites.includes(productId)) {
        favorites = favorites.filter(
            item => item !== productId
        );
    } else {
        favorites.push(productId);
    }

    localStorage.setItem(
        key,
        JSON.stringify(favorites)
    );

    primaV43RefreshFavorites();
}

function primaV43RefreshFavorites() {
    let favorites = [];

    try {
        favorites = JSON.parse(
            localStorage.getItem(
                'prima_house_favorites_v43'
            ) || '[]'
        );
        if (!Array.isArray(favorites)) favorites = [];
    } catch (e) {
        favorites = [];
    }

    document.querySelectorAll(
        '.prima-v43-favorite'
    ).forEach(button => {
        const active = favorites.includes(
            String(button.dataset.productId)
        );

        button.classList.toggle(
            'active',
            active
        );

        button.textContent = active
            ? '♥ Favorit'
            : '♡ Favorit';
    });
}

document.addEventListener(
    'DOMContentLoaded',
    primaV43RefreshFavorites
);
</script>
"""

if "</body>" in html:
    html = html.replace(
        "</body>",
        script + "\n</body>",
        1
    )
else:
    html += script

home.write_text(html)

# CSS V4.3
style = """

/* ==================================
   PRIMA HOUSE V4.3 PRODUCT ACTIONS
================================== */

.prima-v43-actions {
    display: grid;
    grid-template-columns: 1fr;
    gap: 7px;
    margin-top: 9px;
    width: 100%;
}

.prima-v43-favorite {
    width: 100%;
    border: 1px solid #ffb3c7;
    background: #fff5f8;
    color: #e91e63;
    border-radius: 10px;
    padding: 10px 5px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

.prima-v43-favorite.active {
    background: #ffe1eb;
    color: #d6004c;
    border-color: #ff6495;
}

.prima-v43-cart-form {
    width: 100%;
    margin: 0;
}

.prima-v43-cart-btn {
    display: block;
    width: 100%;
    border: none;
    background: linear-gradient(
        135deg,
        #00b140,
        #00d94f
    );
    color: white;
    border-radius: 10px;
    padding: 11px 5px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

.prima-v43-cart-btn:disabled {
    background: #cccccc;
    color: #666666;
    cursor: not-allowed;
}

@media(max-width:600px) {
    .prima-v43-actions {
        gap: 6px;
    }

    .prima-v43-favorite,
    .prima-v43-cart-btn {
        font-size: 11px;
        padding: 9px 3px;
    }

    .product-grid {
        display: grid;
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .product-card {
        min-width: 0;
    }
}
"""

with css.open("a") as f:
    f.write(style)

print("===================================")
print(" V4.3 BERHASIL DIPASANG")
print("===================================")
print("Template kartu diperbarui:", len(insertions))
print("Favorit: AKTIF (localStorage)")
print("Keranjang: FORM POST")
print("Stok habis: DISABLED")
print("Backup:", timestamp)
