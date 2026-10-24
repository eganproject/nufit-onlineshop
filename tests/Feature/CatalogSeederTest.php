<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductVariant;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeds_nufit_catalog_and_is_idempotent(): void
    {
        $this->seed(CatalogSeeder::class);
        $counts = [Category::count(), Product::count(), ProductVariant::count(), ProductCollection::count()];

        $pants = Product::firstWhere('slug', 'nu-shape-aura-flare-yoga-pants');
        $this->assertTrue($pants->has_variants);
        $this->assertSame(112100, (int) $pants->price);
        $this->assertSame(16, $pants->variants()->count());
        $this->assertSame('pants', $pants->category->slug);
        $this->assertSame('fashion-apparel', $pants->category->parent->slug);

        // Varian yang habis di nufit.id ikut habis di sini.
        $this->assertSame(0, ProductVariant::where('name', 'Purple / 0,5 kg (satuan)')->value('stock'));

        $runners = ProductCollection::firstWhere('slug', 'runners');
        $this->assertTrue($runners->products()->where('slug', 'versa-running-belt')->exists());

        $this->seed(CatalogSeeder::class);
        $this->assertSame($counts, [Category::count(), Product::count(), ProductVariant::count(), ProductCollection::count()]);
        $this->assertSame(37, $counts[1]);
    }

    public function test_downloads_and_crops_images_once(): void
    {
        config(['shop.seed_images' => true]);
        Storage::fake('public');

        $image = imagecreatetruecolor(1200, 800);
        ob_start();
        imagejpeg($image);
        Http::fake(['nufit.id/*' => Http::response(ob_get_clean(), 200, ['Content-Type' => 'image/jpeg'])]);

        $this->seed(CatalogSeeder::class);

        $versa = Product::firstWhere('slug', 'versa-running-belt');
        $cover = $versa->images()->orderBy('sort_order')->first();
        [$w, $h] = getimagesizefromstring(Storage::disk('public')->get($cover->path));
        $this->assertSame([800, 800], [$w, $h]);
        $this->assertNotNull($versa->variants()->first()->product_image_id);

        $category = Category::firstWhere('slug', 'running-belt');
        [$w, $h] = getimagesizefromstring(Storage::disk('public')->get($category->image_path));
        $this->assertEqualsWithDelta(1.5, $w / $h, 0.01);

        $requests = count(Http::recorded());
        $this->seed(CatalogSeeder::class);
        $this->assertSame($requests, count(Http::recorded()), 'Gambar yang sudah ada tidak diunduh ulang.');
        $this->assertSame($versa->images()->count(), Product::firstWhere('slug', 'versa-running-belt')->images()->count());
    }
}
