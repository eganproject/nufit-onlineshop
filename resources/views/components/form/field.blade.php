{{--
    Pembungkus isian: label, kontrol (slot), petunjuk, dan pesan error.
    <x-form.field label="Nama" for="name" name="name" hint="..." tip="..." optional>
        <input id="name" name="name" class="input">
    </x-form.field>
    `tip`: penjelasan di tooltip ikon "i" samping label (string, atau array paragraf; lihat x-info-tip).
    `name` dipakai untuk mencari error (boleh "variants[0][price]" atau "variants.0.price").
--}}
@props([
    'label' => null,
    'for' => null,
    'name' => null,
    'hint' => null,
    'tip' => null,
    'optional' => false,
    'bag' => 'default',
])
@php
    $errorKey = \App\Support\FormField::errorKey($name ?? $for);
@endphp
<div {{ $attributes }}>
    @if ($label || isset($labelSlot))
        <label @if ($for) for="{{ $for }}" @endif class="label">
            {{ $label }}{{ $labelSlot ?? '' }}
            @if ($optional)
                <span class="font-normal text-stone-400">({{ is_string($optional) ? $optional : 'opsional' }})</span>
            @endif
            @if ($tip)
                <x-info-tip :text="$tip" :label="$label" />
            @endif
        </label>
    @endif
    {{ $slot }}
    @if ($hint)
        <p class="hint">{{ $hint }}</p>
    @endif
    {{ $after ?? '' }}
    @if ($errorKey)
        <x-input-error :for="$errorKey" :bag="$bag" />
    @endif
</div>
