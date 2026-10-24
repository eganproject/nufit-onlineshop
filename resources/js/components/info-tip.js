/**
 * Tooltip info kecil di samping label isian admin (komponen <x-info-tip>).
 *
 * - Mouse: muncul saat ikon disorot, tetap terbuka saat kursor pindah ke panel.
 * - Keyboard: muncul saat ikon difokus, Esc untuk menutup.
 * - HP/klik: ketuk ikon untuk menyematkan, ketuk di luar (atau ikon lagi) untuk menutup.
 *
 * Panel dipindah ke <body> (x-teleport) dan diposisikan `fixed`, jadi tidak
 * terpotong oleh kartu/tabel yang overflow-nya disembunyikan. Panel muncul di
 * atas ikon supaya tidak menutupi isian di bawah label; turun ke bawah bila
 * ruang di atas tidak cukup.
 */
export default () => ({
    open: false,
    pinned: false,
    placement: 'top',
    style: '',
    arrow: '',
    timer: null,

    init() {
        this.reposition = () => this.open && this.place();
        this.outside = (event) => {
            if (!this.open || this.$refs.btn.contains(event.target) || this.$refs.panel?.contains(event.target)) return;
            this.hide(true);
        };
    },

    show() {
        clearTimeout(this.timer);
        if (this.open) return;
        this.open = true;
        window.addEventListener('scroll', this.reposition, { passive: true, capture: true });
        window.addEventListener('resize', this.reposition, { passive: true });
        document.addEventListener('pointerdown', this.outside, true);
        this.$nextTick(() => this.place());
    },

    hide(force = false) {
        clearTimeout(this.timer);
        if (this.pinned && !force) return;
        this.open = false;
        this.pinned = false;
        window.removeEventListener('scroll', this.reposition, { capture: true });
        window.removeEventListener('resize', this.reposition);
        document.removeEventListener('pointerdown', this.outside, true);
    },

    /** Tutup dengan jeda kecil supaya kursor sempat pindah dari ikon ke panel. */
    hideSoon() {
        clearTimeout(this.timer);
        this.timer = setTimeout(() => this.hide(), 120);
    },

    toggle() {
        if (this.pinned) {
            this.hide(true);
            return;
        }
        this.pinned = true;
        this.show();
    },

    destroy() {
        this.hide(true);
    },

    place() {
        const panel = this.$refs.panel;
        if (!panel) return;

        const gap = 10;
        const margin = 12;
        const btn = this.$refs.btn.getBoundingClientRect();
        const width = Math.min(320, window.innerWidth - margin * 2);
        panel.style.width = `${width}px`;
        const height = panel.offsetHeight;

        this.placement = btn.top - height - gap < margin && window.innerHeight - btn.bottom > btn.top ? 'bottom' : 'top';
        const top = this.placement === 'top' ? btn.top - height - gap : btn.bottom + gap;

        const center = btn.left + btn.width / 2;
        const left = Math.min(Math.max(center - width / 2, margin), window.innerWidth - width - margin);
        const arrowLeft = Math.min(Math.max(center - left, 14), width - 14);

        this.style = `top:${Math.round(top)}px;left:${Math.round(left)}px;width:${width}px`;
        this.arrow = `left:${Math.round(arrowLeft)}px`;
    },
});
