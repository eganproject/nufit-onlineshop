<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class InfoTipTest extends TestCase
{
    use RefreshDatabase;

    public function test_info_tip_renders_accessible_tooltip(): void
    {
        $html = (string) $this->blade('<x-info-tip label="Foto" :text="[\'Ukuran ideal\' => \'1600×1067 px\', \'Objek di tengah.\']" />');

        $this->assertStringContainsString('x-data="infoTip"', $html);
        $this->assertStringContainsString('aria-label="Info: Foto"', $html);
        $this->assertStringContainsString('role="tooltip"', $html);
        $this->assertMatchesRegularExpression('/aria-describedby="(tip-\w+)".*id="\1"/s', $html);
        $this->assertStringContainsString('<strong class="font-semibold text-white">Ukuran ideal:</strong> 1600×1067 px', $html);
        $this->assertStringContainsString('Objek di tengah.', $html);

        // Tanpa teks tidak merender apa pun.
        $this->assertSame('', trim((string) $this->blade('<x-info-tip />')));
    }

    public function test_form_components_show_tip_next_to_label(): void
    {
        view()->share('errors', new ViewErrorBag);

        $html = (string) $this->blade('<x-form.input name="sku" label="SKU" tip="Kode unik internal." />');
        $this->assertStringContainsString('aria-label="Info: SKU"', $html);
        $this->assertStringContainsString('Kode unik internal.', $html);
        $this->assertStringNotContainsString('tip="', $html);

        $html = (string) $this->blade('<x-form.image-upload name="image" label="Foto" :tip="[\'Tampil di\' => \'hero\']" />');
        $this->assertStringContainsString('Tampil di:', $html);

        $html = (string) $this->blade('<x-form.input name="plain" label="Biasa" />');
        $this->assertStringNotContainsString('infoTip', $html);
    }

    public function test_admin_forms_explain_non_obvious_fields(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $this->get(route('admin.collections.create'))->assertOk()
            ->assertSee('role="tooltip"', false)
            ->assertSee('lanskap 3:2, mis. 1600×1067 px')
            ->assertSee('Belanja per aktivitas');
        $this->get(route('admin.categories.create'))->assertOk()->assertSee('hero halaman kategori');
        $this->get(route('admin.products.create'))->assertOk()->assertSee('persegi 1:1');
        $this->get(route('admin.banners.create'))->assertOk()->assertSee('Info: Gambar versi HP', false);
        $this->get(route('admin.vouchers.create'))->assertOk()->assertSee('Info: Tampilkan di checkout', false);
        $this->get(route('admin.storefront.edit'))->assertOk()->assertSee('Info: Foto versi HP', false);
        $this->get(route('admin.store-settings.edit'))->assertOk()->assertSee('Info: Kecamatan', false);
        $this->get(route('admin.articles.create'))->assertOk()->assertSee('Info: Judul SEO', false);
    }
}
