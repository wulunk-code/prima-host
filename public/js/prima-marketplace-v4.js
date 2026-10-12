
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
