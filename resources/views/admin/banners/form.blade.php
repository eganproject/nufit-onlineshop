@php
    $editing = $banner->exists;
@endphp
<x-layouts.admin :title="$editing ? 'Edit Banner' : 'Tambah Banner'">
    <x-admin.page-header :title="$editing ? 'Edit banner' : 'Tambah banner'" :back="route('admin.banners.index')" />

    <form method="POST" enctype="multipart/form-data"
          action="{{ $editing ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
          class="grid gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="space-y-6 lg:col-span-2">
            <div class="card space-y-5 p-6">
                <x-form.image-upload name="image" label="Gambar banner" :current="$editing ? $banner->imageUrl() : null"
                    aspect="aspect-[21/9]" :max-kb="4096" :required="! $editing"
                    :hint="'Disarankan 1920×820 px (rasio ±21:9), JPG/PNG/WebP maks. 4 MB.'.($editing ? ' Kosongkan bila tidak diganti.' : '')"
                    :tip="[
                        'Tampil di' => 'slider promo beranda (desktop & tablet), selebar konten.',
                        'Ukuran ideal' => '1920×820 px (±21:9), JPG/WebP di bawah 1 MB supaya cepat dimuat.',
                        'Komposisi' => 'bila teks ditampilkan, judul muncul di sisi kiri, jadi taruh objek utama di kanan.',
                        'Di HP' => 'tanpa gambar versi HP, gambar ini dipotong 4:3 dari tengah. Jaga objek penting tetap di area tengah.',
                    ]" />
                <x-form.image-upload name="mobile_image" label="Gambar versi HP" optional :current="$banner->mobileImageUrl()"
                    remove-name="remove_mobile_image" aspect="aspect-[4/5]" wrapper-class="max-w-56" :max-kb="4096"
                    hint="Rasio 4:5 (mis. 1080×1350 px). Tanpa ini, gambar utama dipotong otomatis di HP."
                    :tip="[
                        'Dipakai di' => 'layar HP (lebar di bawah 640 px), menggantikan gambar utama.',
                        'Ukuran ideal' => 'potret 4:5, mis. 1080×1350 px.',
                        'Komposisi' => 'judul & tombol tampil di bagian bawah, jadi taruh objek di atas/tengah dan biarkan sepertiga bawah lega.',
                    ]" />
            </div>

            <div class="card space-y-5 p-6">
                <div>
                    <label for="title" class="label">Judul<x-info-tip label="Judul" text="Judul besar di atas gambar bila “Tampilkan teks” aktif. Bila teks dimatikan, judul jadi teks alternatif gambar untuk pembaca layar & mesin pencari. Buat singkat, 3–6 kata." /></label>
                    <input id="title" name="title" value="{{ old('title', $banner->title) }}" required maxlength="120" placeholder="Diskon 10% koleksi yoga" class="input @error('title') input-error @enderror">
                    <p class="mt-1.5 text-xs text-stone-400">Juga dipakai sebagai teks alternatif gambar.</p>
                    <x-input-error for="title" />
                </div>
                <div>
                    <label for="subtitle" class="label">Subjudul <span class="font-normal text-stone-400">(opsional)</span></label>
                    <input id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" maxlength="255" placeholder="Pakai kode HEMAT10 sampai akhir bulan" class="input">
                    <x-input-error for="subtitle" />
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="link_url" class="label">Link <span class="font-normal text-stone-400">(opsional)</span><x-info-tip label="Link" :text="['Halaman yang dibuka saat banner diklik. Kosong = banner tidak bisa diklik.', 'Contoh' => '/produk?promo=1, /produk?koleksi=running, atau https://... untuk link luar (dibuka di tab baru).']" /></label>
                        <input id="link_url" name="link_url" value="{{ old('link_url', $banner->link_url) }}" maxlength="500" placeholder="/produk?promo=1" class="input @error('link_url') input-error @enderror">
                        <x-input-error for="link_url" />
                    </div>
                    <div>
                        <label for="button_label" class="label">Teks tombol <span class="font-normal text-stone-400">(opsional)</span><x-info-tip label="Teks tombol" text="Tombol di atas banner. Hanya muncul bila Link diisi dan “Tampilkan teks” aktif. Contoh: “Belanja sekarang”, “Lihat promo”." /></label>
                        <input id="button_label" name="button_label" value="{{ old('button_label', $banner->button_label) }}" maxlength="40" placeholder="Belanja sekarang" class="input">
                        <x-input-error for="button_label" />
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card space-y-5 p-6">
                <label class="flex items-center justify-between gap-3">
                    <span><span class="block text-sm font-semibold text-stone-800">Tampilkan di beranda</span><span class="text-xs text-stone-500">Nonaktifkan untuk menyembunyikan</span></span>
                    <input type="checkbox" name="is_active" value="1" class="checkbox size-5" @checked(old('is_active', $banner->is_active))>
                </label>
                <label class="flex items-center justify-between gap-3">
                    <span><span class="block text-sm font-semibold text-stone-800">Tampilkan teks di atas gambar<x-info-tip label="Tampilkan teks di atas gambar" text="Aktif: judul, subjudul, dan tombol ditulis di atas gambar dengan lapisan gelap supaya terbaca. Matikan bila desain gambar sudah memuat tulisan, supaya tidak dobel." /></span><span class="text-xs text-stone-500">Matikan bila tulisan sudah ada di gambar</span></span>
                    <input type="checkbox" name="show_text" value="1" class="checkbox size-5" @checked(old('show_text', $banner->show_text))>
                </label>
                <x-form.number name="sort_order" label="Urutan tampil" :value="$banner->sort_order ?? 0" min="0"
                    tip="Urutan di slider; angka kecil tampil lebih dulu. Banner pertama dimuat paling cepat, jadi taruh promo terpenting di urutan teratas." />
                <x-form.date name="starts_at" label="Mulai tayang" optional time :value="$banner->starts_at"
                    tip="Banner otomatis muncul mulai waktu ini (WIB). Kosongkan untuk langsung tayang. Cocok untuk menyiapkan promo lebih awal." />
                <x-form.date name="ends_at" label="Berakhir" optional time :value="$banner->ends_at"
                    tip="Banner otomatis hilang setelah waktu ini (WIB). Kosongkan bila tayang tanpa batas." />
            </div>
            <button class="btn btn-primary w-full py-3">{{ $editing ? 'Simpan perubahan' : 'Simpan banner' }}</button>
        </div>
    </form>
</x-layouts.admin>
