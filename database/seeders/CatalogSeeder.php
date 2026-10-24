<?php

namespace Database\Seeders;

use App\Enums\StockMovementType;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductVariant;
use App\Services\Catalog\StockService;
use GdImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Kategori, koleksi & produk contoh yang sama dengan isi nufit.id
 * (data di database/seeders/data/nufit-catalog.php).
 *
 * Aman dijalankan ulang: semua dicocokkan lewat slug / nama varian, stok
 * awal hanya diisi saat varian baru dibuat. Gambar diunduh dari nufit.id
 * sekali ke disk public (folder seed/nufit) lalu dipakai ulang; produk
 * di-crop kotak, kategori & koleksi lanskap 3:2. Tanpa internet (atau
 * SEED_IMAGES=false, bawaan saat tes) gambar dilewati dan toko tetap jalan.
 */
class CatalogSeeder extends Seeder
{
    private const DIR = 'seed/nufit';

    private array $data;

    private bool $images;

    private int $failedImages = 0;

    public function __construct(private readonly StockService $stock)
    {
        $this->data = require __DIR__.'/data/nufit-catalog.php';
        $this->images = (bool) config('shop.seed_images', true);
    }

    public function run(): void
    {
        if ($this->images) {
            $this->command?->info('Mengunduh gambar katalog dari nufit.id (sekali saja, berikutnya dipakai ulang)...');
        }

        $categories = $this->seedCategories();
        $products = collect($this->data['products'])
            ->mapWithKeys(fn (array $item) => [Str::slug($item['name']) => $this->seedProduct($item, $categories[$item['category']])]);
        $this->seedCollections($products);

        if ($this->failedImages) {
            $this->command?->warn("{$this->failedImages} gambar gagal diunduh dari nufit.id; jalankan seeder lagi saat online untuk melengkapinya.");
        }
    }

    /** @return array<string, Category> */
    private function seedCategories(): array
    {
        $categories = [];
        $order = 0;

        foreach ($this->data['categories'] as $slug => [$name, $parent, $image, $description]) {
            $category = Category::updateOrCreate(['slug' => $slug], [
                'parent_id' => $parent ? $categories[$parent]->id : null,
                'name' => $name,
                'description' => $description,
                'is_active' => true,
                'sort_order' => $order++,
            ]);

            if ($path = $this->image($image, "categories/{$slug}", 1600, 1067)) {
                $category->update(['image_path' => $path]);
            }

            $categories[$slug] = $category;
        }

        return $categories;
    }

    /** @param Collection<string, Product> $products */
    private function seedCollections($products): void
    {
        foreach ($this->data['collections'] as $order => [$name, $slug, $icon, $tone, $tagline, $image]) {
            $collection = ProductCollection::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'tagline' => $tagline,
                'description' => "Perlengkapan {$name} pilihan NuFit, dari berbagai kategori.",
                'icon' => $icon,
                'tone' => $tone,
                'is_active' => true,
                'show_on_home' => true,
                'sort_order' => $order,
            ]);

            if ($path = $this->image($image, "collections/{$slug}", 1600, 1067)) {
                $collection->update(['image_path' => $path]);
            }

            $ids = collect($this->data['products'])
                ->filter(fn (array $item) => in_array($slug, $item['collections'], true))
                ->map(fn (array $item) => $products[Str::slug($item['name'])]->id);

            $collection->products()->sync($ids->values()->all());
        }
    }

    private function seedProduct(array $item, Category $category): Product
    {
        $slug = Str::slug($item['name']);
        $product = Product::updateOrCreate(['slug' => $slug], [
            'category_id' => $category->id,
            'name' => $item['name'],
            'sku' => 'NF-'.Str::upper(Str::substr(md5($slug), 0, 6)),
            'description' => $item['description'],
            'price' => $item['price'],
            'compare_at_price' => $item['compare'] ?? null,
            'weight' => $item['weight'],
            'variant_label' => $item['variants']['label'] ?? null,
            'is_active' => true,
            'is_featured' => $item['featured'] ?? false,
        ]);

        $variants = $this->variantRows($item);

        // Foto varian (warna) di depan, lalu foto galeri bersama.
        $paths = collect($variants)->pluck('image')->merge($item['images'])->filter()->unique()->values();
        $imageIds = [];
        foreach ($paths as $position => $source) {
            if ($path = $this->image($source, "products/{$slug}", 1000, 1000)) {
                $imageIds[$source] = $product->images()->firstOrCreate(['path' => $path], ['sort_order' => $position])->id;
            }
        }
        $product->unsetRelation('coverImage')->unsetRelation('images');

        if (! $variants) {
            if ($product->wasRecentlyCreated) {
                $this->stock->adjust($product, null, random_int(10, 80), StockMovementType::Initial);
            }

            return $product;
        }

        foreach ($variants as $position => $row) {
            $variant = ProductVariant::firstOrNew(['product_id' => $product->id, 'name' => $row['name']]);
            $isNew = ! $variant->exists;
            $variant->fill([
                'sku' => $product->sku.'-'.Str::upper(Str::substr(Str::slug($row['name'], ''), 0, 14)),
                'price' => $row['price'] ?? $item['price'],
                'compare_at_price' => $row['compare'] ?? null,
                'product_image_id' => $imageIds[$row['image']] ?? null,
                'is_active' => true,
                'sort_order' => $position,
            ])->save();

            if ($isNew && ! $row['sold_out']) {
                $this->stock->adjust($product, $variant, random_int(5, 40), StockMovementType::Initial);
            }
        }

        $product->syncVariantSummary();

        return $product;
    }

    /** @return list<array{name: string, price: ?int, compare: ?int, image: ?string, sold_out: bool}> */
    private function variantRows(array $item): array
    {
        $spec = $item['variants'] ?? null;
        if (! $spec) {
            return [];
        }

        if (isset($spec['options'])) {
            return array_map(fn (array $o) => [
                'name' => $o[0],
                'price' => $o[1] ?? null,
                'image' => $o[2] ?? null,
                'sold_out' => $o[3] ?? false,
                'compare' => $o[4] ?? null,
            ], $spec['options']);
        }

        $rows = [];
        foreach ($spec['colors'] as $color => $c) {
            foreach ($spec['sizes'] as $size => $sizePrice) {
                $rows[] = [
                    'name' => "{$color} / {$size}",
                    'price' => $sizePrice ?? $c[1] ?? null,
                    'image' => $c[0] ?? null,
                    'sold_out' => $c[2] ?? false,
                    'compare' => null,
                ];
            }
        }

        return $rows;
    }

    /**
     * Unduh (sekali) gambar nufit.id lalu crop tengah ke ukuran tujuan.
     * Mengembalikan path di disk public, atau null bila tidak tersedia.
     */
    private function image(?string $source, string $folder, int $width, int $height): ?string
    {
        if (! $source) {
            return null;
        }

        $path = self::DIR."/{$folder}/".Str::slug(pathinfo($source, PATHINFO_FILENAME)).'.jpg';
        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            return $path;
        }

        if (! $this->images) {
            return null;
        }

        try {
            $response = Http::timeout(30)->retry(2, 500, throw: false)->get($this->data['image_base'].$source);
            if (! $response->successful()) {
                throw new \RuntimeException('HTTP '.$response->status());
            }

            $disk->put($path, $this->fit($response->body(), $width, $height));
            $this->command?->getOutput()->write('.');

            return $path;
        } catch (Throwable $e) {
            $this->failedImages++;
            $this->command?->getOutput()->write('x');

            return null;
        }
    }

    /** Crop tengah + perkecil ke JPEG (latar putih untuk PNG transparan). Tanpa GD → file asli. */
    private function fit(string $body, int $width, int $height): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $body;
        }

        $source = @imagecreatefromstring($body);
        if (! $source instanceof GdImage) {
            throw new \RuntimeException('bukan gambar');
        }

        $sw = imagesx($source);
        $sh = imagesy($source);
        $ratio = $width / $height;

        // Area crop terbesar dengan rasio tujuan, di tengah gambar.
        [$cw, $ch] = $sw / $sh > $ratio ? [(int) round($sh * $ratio), $sh] : [$sw, (int) round($sw / $ratio)];
        $scale = min(1, $width / $cw);
        [$tw, $th] = [(int) round($cw * $scale), (int) round($ch * $scale)];

        $target = imagecreatetruecolor($tw, $th);
        imagefill($target, 0, 0, imagecolorallocate($target, 255, 255, 255));
        imagecopyresampled($target, $source, 0, 0, intdiv($sw - $cw, 2), intdiv($sh - $ch, 2), $tw, $th, $cw, $ch);

        ob_start();
        imagejpeg($target, null, 82);

        return (string) ob_get_clean();
    }
}
