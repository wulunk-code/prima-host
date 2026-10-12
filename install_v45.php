<?php

echo "\n===== PRIMA HOST V4.5 =====\n";

$home = 'resources/views/home.blade.php';
$controller = 'app/Http/Controllers/CartController.php';

if (!is_file($home) || !is_file($controller)) {
    exit("ERROR: File utama tidak ditemukan.\n");
}

$source = file_get_contents($home);
$cart = file_get_contents($controller);

$backup = 'backup_v45_' . date('Ymd_His');

if (!mkdir($backup, 0755)) {
    exit("ERROR: Gagal membuat backup.\n");
}

if (!copy($home, "$backup/home.blade.php") ||
    !copy($controller, "$backup/CartController.php")) {
    exit("ERROR: Backup gagal.\n");
}

echo "Backup: $backup\n";

/*
|--------------------------------------------------------------------------
| TOMBOL KERANJANG DAN FAVORIT
|--------------------------------------------------------------------------
*/

$buttons = <<<'HTML'

<div class="prima-v45-actions">

<form class="prima-v45-cart"
      action="{{ url('/cart/add/'.$product->id) }}"
      method="POST">

@csrf

<button type="submit"
        class="prima-v45-add"
        @if($product->stock <= 0) disabled @endif>
    🛒 Keranjang
</button>

</form>

<button type="button"
        class="prima-v45-fav"
        data-id="{{ $product->id }}">
    ♡ Favorit
</button>

</div>
HTML;

/*
|--------------------------------------------------------------------------
| TAMBAHKAN TOMBOL SETELAH LIHAT DETAIL
|--------------------------------------------------------------------------
*/

$pattern = '~(<a\b[^>]*class=["\'][^"\']*\bbtn-detail\b[^"\']*["\'][^>]*>.*?</a>)~s';

$count = 0;

$source = preg_replace_callback(
    $pattern,
    function ($matches) use ($buttons, &$count) {
        $count++;

        return $matches[1] . "\n" . $buttons;
    },
    $source
);

if ($count === 0) {
    exit("ERROR: Tombol detail tidak ditemukan. Backup tersedia.\n");
}

/*
|--------------------------------------------------------------------------
| CSS DAN JAVASCRIPT
|--------------------------------------------------------------------------
*/

$code = <<<'HTML'

<style id="prima-v45-style">
.prima-v45-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:6px;
    margin-top:8px;
}

.prima-v45-cart{
    margin:0;
}

.prima-v45-add,
.prima-v45-fav{
    width:100%;
    min-height:38px;
    border-radius:9px;
    font-size:12px;
    font-weight:700;
    cursor:pointer;
}

.prima-v45-add{
    background:#ff7900;
    color:white;
    border:0;
}

.prima-v45-add:disabled{
    background:#aaa;
    cursor:not-allowed;
}

.prima-v45-fav{
    background:#fff1f4;
    color:#e91e63;
    border:1px solid #ffc7d6;
}

.prima-v45-fav.active{
    background:#e91e63;
    color:white;
}

.prima-v45-toast{
    position:fixed;
    bottom:90px;
    left:50%;
    transform:translateX(-50%);
    background:#222;
    color:white;
    padding:12px 18px;
    border-radius:12px;
    z-index:99999;
    font-size:13px;
    text-align:center;
    max-width:90%;
}
</style>

<script id="prima-v45-script">
document.addEventListener('DOMContentLoaded',function(){

function toast(message){
    const old=document.querySelector('.prima-v45-toast');
    if(old) old.remove();

    const box=document.createElement('div');
    box.className='prima-v45-toast';
    box.textContent=message;

    document.body.appendChild(box);

    setTimeout(()=>box.remove(),2500);
}

document.querySelectorAll('.prima-v45-cart').forEach(form=>{

    form.addEventListener('submit',async function(e){

        e.preventDefault();

        const button=form.querySelector('button');

        if(button.disabled) return;

        button.disabled=true;

        try{
            const response=await fetch(form.action,{
                method:'POST',
                body:new FormData(form),
                credentials:'same-origin',
                headers:{
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest'
                }
            });

            if(!response.ok){
                throw new Error('Gagal menambahkan produk');
            }

            const data=await response.json();

            if(!data.success){
                throw new Error(data.message || 'Gagal');
            }

            toast('✅ Produk berhasil ditambahkan!');

            let badge=document.querySelector('.cart-btn .cart-badge');

            if(!badge){
                badge=document.createElement('span');
                badge.className='cart-badge';

                const cart=document.querySelector('.cart-btn');
                if(cart) cart.appendChild(badge);
            }

            if(badge && data.cart_count !== undefined){
                badge.textContent=data.cart_count;
            }

        }catch(error){
            toast('❌ '+error.message);
        }finally{
            button.disabled=false;
        }
    });
});

let favorites=[];

try{
    favorites=JSON.parse(localStorage.getItem('prima_favorites') || '[]');
    if(!Array.isArray(favorites)) favorites=[];
}catch(e){
    favorites=[];
}

document.querySelectorAll('.prima-v45-fav').forEach(button=>{

    const id=String(button.dataset.id);

    if(favorites.includes(id)){
        button.classList.add('active');
        button.textContent='♥ Favorit';
    }

    button.addEventListener('click',function(){

        if(favorites.includes(id)){
            favorites=favorites.filter(x=>x!==id);
            button.classList.remove('active');
            button.textContent='♡ Favorit';
            toast('Favorit dihapus');
        }else{
            favorites.push(id);
            button.classList.add('active');
            button.textContent='♥ Favorit';
            toast('❤️ Ditambahkan ke favorit');
        }

        localStorage.setItem(
            'prima_favorites',
            JSON.stringify(favorites)
        );
    });
});

});
</script>
HTML;

if (strpos($source, 'prima-v45-script') === false) {
    $source = str_replace('</body>', $code . "\n</body>", $source);
}

/*
|--------------------------------------------------------------------------
| AJAX CART CONTROLLER
|--------------------------------------------------------------------------
*/

$start = strpos($cart, 'public function add($id)');

if ($start === false) {
    exit("ERROR: Fungsi add tidak ditemukan.\n");
}

$open = strpos($cart, '{', $start);

$depth = 0;
$end = null;

for ($i = $open; $i < strlen($cart); $i++) {
    if ($cart[$i] === '{') $depth++;
    if ($cart[$i] === '}') $depth--;

    if ($depth === 0) {
        $end = $i + 1;
        break;
    }
}

if ($end === null) {
    exit("ERROR: Struktur CartController tidak valid.\n");
}

$newFunction = <<<'CODE'
public function add($id)
{
    $product = \App\Models\Product::findOrFail($id);

    $cart = session()->get('cart', []);

    $currentQty = $cart[$id]['qty'] ?? 0;

    if ($product->stock <= $currentQty) {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ], 422);
        }

        return back()->with(
            'error',
            'Stok produk tidak mencukupi'
        );
    }

    if (isset($cart[$id])) {
        $cart[$id]['qty']++;
    } else {
        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty' => 1
        ];
    }

    session()->put('cart', $cart);

    if (request()->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'cart_count' => array_sum(
                array_column($cart, 'qty')
            )
        ]);
    }

    return redirect()
        ->route('cart.index')
        ->with('success', 'Produk berhasil ditambahkan');
}
CODE;

$cart = substr_replace(
    $cart,
    $newFunction,
    $start,
    $end - $start
);

if (file_put_contents($home, $source) === false ||
    file_put_contents($controller, $cart) === false) {
    copy("$backup/home.blade.php", $home);
    copy("$backup/CartController.php", $controller);
    exit("ERROR: Gagal menyimpan perubahan. Backup dipulihkan.\n");
}

echo "Tombol detail ditemukan: $count\n";
echo "Prima Host V4.5 terpasang.\n";
echo "Backup tersedia: $backup\n";
