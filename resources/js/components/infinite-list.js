/**
 * Muat halaman berikutnya otomatis saat pengguna mendekati akhir daftar.
 * Markup & alur server: resources/views/components/infinite-list.blade.php.
 * Permintaan memakai header X-Infinite sehingga server hanya mengirim fragmen daftar.
 */
export default (next) => ({
    next,
    loading: false,
    error: false,
    shown: 0,
    total: 0,
    observer: null,

    init() {
        this.shown = Number(this.$el.dataset.shown) || 0;
        this.total = Number(this.$el.dataset.total) || 0;

        if (!this.next || !this.$refs.sentinel || !('IntersectionObserver' in window)) return;

        this.observer = new IntersectionObserver((entries) => {
            if (entries.some((entry) => entry.isIntersecting)) this.load();
        }, { rootMargin: '0px 0px 800px 0px' });
        this.observer.observe(this.$refs.sentinel);
    },

    destroy() {
        this.observer?.disconnect();
    },

    async load() {
        if (!this.next || this.loading) return;

        this.loading = true;
        this.error = false;

        try {
            const response = await fetch(this.next, {
                headers: { 'X-Infinite': '1', 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
                credentials: 'same-origin',
                cache: 'no-store',
            });
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const template = document.createElement('template');
            template.innerHTML = await response.text();
            const root = template.content.querySelector('[data-infinite]');
            const items = root?.querySelector('[data-infinite-items]');
            if (!items) throw new Error('Fragmen daftar tidak ditemukan');

            const nodes = [...items.children];
            this.$refs.items.append(...nodes);
            this.shown += nodes.length;
            this.next = root.dataset.next || null;
        } catch (error) {
            // Berhenti otomatis; tombol "Coba muat lagi" tetap bisa ditekan.
            this.error = true;
            this.observer?.disconnect();
            this.observer = null;
        } finally {
            this.loading = false;
        }

        if (!this.next) {
            this.observer?.disconnect();
        } else if (this.observer) {
            // Penanda masih terlihat (layar tinggi): amati ulang supaya halaman berikutnya ikut dimuat.
            this.$nextTick(() => {
                this.observer.unobserve(this.$refs.sentinel);
                this.observer.observe(this.$refs.sentinel);
            });
        }
    },
});
