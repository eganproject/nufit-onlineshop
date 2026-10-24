/**
 * Halaman keranjang tanpa reload: tombol +/− dan "Hapus" (form [data-cart-line])
 * dikirim lewat fetch, lalu isi keranjang (#cart-content) diganti HTML terbaru dari server
 * sehingga subtotal, total, batas stok, dan pesan penyesuaian selalu sesuai hitungan server.
 * Tanpa JS, form tetap dikirim biasa.
 */
async function onSubmit(event) {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.matches('[data-cart-line]') || event.defaultPrevented) return;

    const root = form.closest('[data-cart-root]');
    if (!root) return;

    event.preventDefault();

    // Satu perubahan sekaligus supaya klik cepat tidak saling menimpa.
    if (root.dataset.busy) return;
    root.dataset.busy = '1';
    root.setAttribute('aria-busy', 'true');
    const line = form.closest('li') ?? root;
    line.classList.add('opacity-60', 'pointer-events-none', 'transition-opacity');

    const body = new FormData(form);
    if (event.submitter?.name) body.set(event.submitter.name, event.submitter.value);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body,
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });

        // Sesi kedaluwarsa / item sudah tidak ada: muat ulang supaya tampilan sesuai isi keranjang.
        if (!response.ok || response.redirected || !(response.headers.get('content-type') || '').includes('json')) {
            if (response.status === 422) {
                const json = await response.json().catch(() => ({}));
                window.toast(json.message || 'Jumlah tidak valid.', 'error');
                return;
            }
            window.location.reload();
            return;
        }

        const json = await response.json();
        const fresh = document.createRange().createContextualFragment(json.html).querySelector('[data-cart-root]');
        if (fresh) root.replaceWith(fresh);
        if (json.message) window.toast(json.message, json.type || 'success');
        window.dispatchEvent(new CustomEvent('cart-updated', { detail: json }));
    } catch (error) {
        window.toast('Koneksi terputus. Perubahan belum tersimpan, coba lagi.', 'error');
    } finally {
        // Bila root sudah diganti, elemen lama ini tidak lagi di halaman.
        delete root.dataset.busy;
        root.removeAttribute('aria-busy');
        line.classList.remove('opacity-60', 'pointer-events-none', 'transition-opacity');
    }
}

export default function cartPage() {
    document.addEventListener('submit', onSubmit);
}
