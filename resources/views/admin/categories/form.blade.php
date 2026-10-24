@php($editing = $category->exists)
<x-layouts.admin :title="$editing ? 'Edit Kategori' : 'Tambah Kategori'">
    <x-admin.page-header :title="$editing ? 'Edit kategori' : 'Tambah kategori'" :back="route('admin.categories.index')" />

    <form method="POST" enctype="multipart/form-data"
          action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="grid gap-6 lg:grid-cols-3">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="card space-y-5 p-6 lg:col-span-2">
            <div>
                <label for="name" class="label">Nama kategori</label>
                <input id="name" name="name" value="{{ old('name', $category->name) }}" required class="input @error('name') input-error @enderror">
                <x-input-error for="name" />
            </div>
            <x-form.select name="parent_id" label="Induk kategori" placeholder="Tidak ada (kategori utama)" :search="true"
                :options="$parents->pluck('name', 'id')->all()" :selected="$category->parent_id"
                hint="Pilih induk untuk menjadikannya subkategori, mis. Running › Running Belt."
                tip="Kategori maks. 2 tingkat. Subkategori tampil di bawah induknya di menu & filter katalog, dan jumlah produknya ikut dihitung di kategori induk." />
            <div>
                <label for="slug" class="label">Slug URL <span class="font-normal text-stone-400">(kosongkan untuk otomatis)</span><x-info-tip label="Slug URL" :text="['Bagian alamat halaman kategori: /produk?kategori=slug.', 'Kosongkan supaya dibuat otomatis dari nama. Hindari mengganti slug yang sudah dibagikan, karena link lama tidak lagi membuka kategori ini.']" /></label>
                <input id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="input @error('slug') input-error @enderror">
                <x-input-error for="slug" />
            </div>
            <x-form.textarea name="description" label="Deskripsi" optional :value="$category->description" rows="4" maxlength="1000"
                :tip="['Tampil di' => 'bawah judul hero halaman kategori, dan sebagai deskripsi halaman di hasil pencarian Google.', 'Tips' => '1–2 kalimat (±150 karakter). Bila kosong, dipakai kalimat umum.']" />
        </div>

        <div class="space-y-6">
            <div class="card space-y-5 p-6">
                <label class="flex items-center justify-between gap-3">
                    <span><span class="block text-sm font-semibold text-stone-800">Tampilkan di toko<x-info-tip label="Tampilkan di toko" text="Matikan untuk menyembunyikan kategori dari menu, filter katalog, dan beranda tanpa menghapusnya." /></span><span class="text-xs text-stone-500">Nonaktifkan untuk menyembunyikan</span></span>
                    <input type="checkbox" name="is_active" value="1" class="checkbox size-5" @checked(old('is_active', $category->is_active))>
                </label>
                <x-form.number name="sort_order" label="Urutan tampil" :value="$category->sort_order ?? 0" min="0"
                    tip="Angka kecil tampil lebih dulu di menu & filter kategori. Bila beranda memakai kategori, kategori induk urutan pertama jadi ubin besar “Belanja per aktivitas”." />
                <x-form.image-upload name="image" label="Gambar" optional :current="$category->imageUrl()" remove-name="remove_image" aspect="aspect-[3/2]"
                    hint="Opsional. Lanskap 3:2, mis. 1600×1067 px."
                    :tip="[
                        'Tampil di' => 'hero halaman kategori: sisi kanan di desktop, latar penuh di HP. Subkategori tanpa gambar memakai gambar induknya.',
                        'Juga dipakai' => 'di ubin “Belanja per aktivitas” beranda (khusus kategori induk) bila beranda memakai kategori.',
                        'Ukuran ideal' => 'lanskap 3:2, mis. 1600×1067 px (lebar min. 1200 px). JPG/WebP, maks. 2 MB.',
                        'Komposisi' => 'objek utama di tengah, beri ruang di sekeliling. Hero desktop lebar dan di HP hampir persegi, jadi tepi foto bisa terpotong. Hindari tulisan di foto.',
                    ]" />
            </div>
            <button class="btn btn-primary w-full py-3">{{ $editing ? 'Simpan perubahan' : 'Simpan kategori' }}</button>
        </div>
    </form>
</x-layouts.admin>
