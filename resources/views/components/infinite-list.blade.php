{{--
    Daftar yang memuat halaman berikutnya otomatis saat di-scroll (Alpine `infiniteList`).
    Bungkus pemanggilannya dengan @fragment('infinite') di view halaman, lalu di controller
    `->fragmentIf($request->hasHeader('X-Infinite'), 'infinite')` supaya permintaan lanjutan
    hanya mengirim potongan daftar. Tanpa JS, tombol "Tampilkan lebih banyak" = tautan ?page=N
    biasa (tetap bisa dirayapi mesin pencari).
    Contoh: <x-infinite-list :paginator="$products" label="produk" class="grid grid-cols-2 gap-4">…</x-infinite-list>
--}}
@props(['paginator', 'label' => 'produk'])
@php
    $next = $paginator->nextPageUrl();
    $shown = (int) $paginator->lastItem();
    $total = $paginator->total();
@endphp
<div x-data="infiniteList(@js($next))" data-infinite data-next="{{ $next }}" data-shown="{{ $shown }}" data-total="{{ $total }}">
    <div data-infinite-items x-ref="items" {{ $attributes }}>{{ $slot }}</div>

    @if ($paginator->hasPages())
        <div class="mt-12 flex flex-col items-center gap-3 text-center lg:mt-16" x-ref="sentinel">
            <p class="text-sm text-stone-500">
                Menampilkan <span class="font-semibold text-ink" x-text="shown.toLocaleString('id-ID')">{{ number_format($shown, 0, ',', '.') }}</span>
                dari {{ number_format($total, 0, ',', '.') }} {{ $label }}
            </p>
            <div class="h-1 w-44 overflow-hidden rounded-full bg-sand-200" aria-hidden="true">
                <div class="h-full rounded-full bg-ink transition-[width] duration-500" style="width: {{ $total ? round($shown / $total * 100) : 100 }}%" :style="`width: ${total ? Math.round(shown / total * 100) : 100}%`"></div>
            </div>
            @if ($next)
                <a href="{{ $next }}" rel="next" x-show="next && ! loading" @click.prevent="load()" class="btn btn-outline btn-pill mt-3 min-h-12 px-7">
                    <span x-text="error ? 'Coba muat lagi' : 'Tampilkan lebih banyak'">Tampilkan lebih banyak</span>
                </a>
                <p x-show="loading" x-cloak class="mt-3 inline-flex min-h-12 items-center gap-2.5 text-sm text-stone-500" role="status">
                    <span class="size-4 animate-spin rounded-full border-2 border-stone-300 border-t-ink"></span> Memuat {{ $label }}…
                </p>
            @endif
            @if ($paginator->currentPage() > 1)
                <a href="{{ $paginator->url(1) }}" class="text-sm font-medium text-stone-500 underline decoration-stone-300 underline-offset-4 hover:text-ink">Lihat dari awal</a>
            @endif
        </div>
    @endif
</div>
