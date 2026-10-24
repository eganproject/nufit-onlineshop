{{-- Paginasi bawaan halaman pelanggan (ulasan, pesanan). Daftar produk/artikel memakai <x-infinite-list>. --}}
@if ($paginator->hasPages())
    @php($btn = 'grid size-10 place-items-center rounded-full text-sm font-medium transition')
    <nav role="navigation" aria-label="Navigasi halaman" class="flex flex-col items-center gap-3">
        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="{{ $btn }} text-stone-300" aria-disabled="true" aria-label="Sebelumnya"><x-icon name="arrow-left" class="size-4" /></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $btn }} text-ink hover:bg-sand-100" aria-label="Sebelumnya"><x-icon name="arrow-left" class="size-4" /></a>
            @endif

            {{-- Nomor halaman (disembunyikan di layar sangat sempit) --}}
            <div class="hidden items-center gap-1 min-[400px]:flex">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="{{ $btn }} text-stone-400" aria-disabled="true">…</span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="{{ $btn }} bg-ink text-white" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="{{ $btn }} text-stone-600 hover:bg-sand-100 hover:text-ink" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <span class="px-3 text-sm text-stone-500 min-[400px]:hidden">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $btn }} text-ink hover:bg-sand-100" aria-label="Berikutnya"><x-icon name="arrow-right" class="size-4" /></a>
            @else
                <span class="{{ $btn }} text-stone-300" aria-disabled="true" aria-label="Berikutnya"><x-icon name="arrow-right" class="size-4" /></span>
            @endif
        </div>
        @if ($paginator->total())
            <p class="text-xs text-stone-500">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}</p>
        @endif
    </nav>
@endif
