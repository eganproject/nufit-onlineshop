{{--
    Ikon "i" kecil dengan tooltip penjelasan, untuk isian yang fungsinya kurang jelas.
    <x-info-tip text="Dipakai untuk ..." />
    <x-info-tip label="Foto" :text="['Tampil di' => 'ubin beranda & hero halaman', 'Ukuran ideal' => '1600×1067 px', 'Objek di tengah.']" />
    Teks berupa array = satu paragraf per item; item dengan kunci teks tampil sebagai "Kunci: isi" (kunci tebal).
    Di form, cukup pakai prop `tip` di komponen x-form.* (input, select, image-upload, ...).
    Aman diletakkan di dalam <label>: klik ikon tidak ikut mencentang/membuka isian.
--}}
@props([
    'text' => null,
    'label' => null,
    'title' => null,
])
@php
    $items = is_array($text) ? $text : array_filter([$text], 'filled');
    $id = 'tip-'.\Illuminate\Support\Str::random(8);
    $label = trim(strip_tags((string) $label));
@endphp
@if ($items || $slot->isNotEmpty())
    <span x-data="infoTip" {{ $attributes->class('info-tip') }}
          @keydown.escape.stop="hide(true); $refs.btn.focus()">
        <button type="button" x-ref="btn" class="info-tip-btn"
                aria-label="{{ $label !== '' ? 'Info: '.$label : 'Info' }}" aria-describedby="{{ $id }}" x-bind:aria-expanded="open.toString()"
                @mouseenter="show()" @mouseleave="hideSoon()" @focus="show()" @blur="hide()" @click.prevent.stop="toggle()">
            <x-icon name="info" class="size-4" />
        </button>
        <template x-teleport="body">
            <span x-ref="panel" id="{{ $id }}" role="tooltip" x-show="open" x-cloak
                  x-transition:enter="transition duration-150 ease-out" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition duration-100 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                  class="info-tip-panel" x-bind:class="placement === 'bottom' && 'is-bottom'" x-bind:style="style"
                  @mouseenter="show()" @mouseleave="hideSoon()">
                <span class="info-tip-arrow" x-bind:style="arrow" aria-hidden="true"></span>
                @if ($title)
                    <span class="mb-1 block font-semibold text-white">{{ $title }}</span>
                @endif
                @foreach ($items as $key => $item)
                    <span class="info-tip-line">
                        @if (is_string($key))<strong class="font-semibold text-white">{{ $key }}:</strong> @endif{{ $item }}
                    </span>
                @endforeach
                @if ($slot->isNotEmpty())
                    <span class="info-tip-line">{{ $slot }}</span>
                @endif
            </span>
        </template>
    </span>
@endif
