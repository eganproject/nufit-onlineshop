<?php

/*
|--------------------------------------------------------------------------
| Katalog contoh = produk yang benar-benar dijual di nufit.id
|--------------------------------------------------------------------------
|
| Diambil dari toko WooCommerce nufit.id (Oktober 2026). Di sana tiap warna
| adalah listing tersendiri; di sini digabung jadi satu produk bervarian.
| Harga = harga tayang di nufit.id. Berat (gram) = perkiraan untuk ongkir.
| Gambar = path di bawah `image_base`, diunduh oleh CatalogSeeder.
|
| Varian:
|   'variants' => ['label' => 'Warna', 'options' => [[nama, harga|null, gambar|null, habis?], ...]]
|   atau kombinasi warna × ukuran:
|   'variants' => ['label' => 'Warna / Ukuran', 'colors' => [nama => [gambar, harga|null, habis?]], 'sizes' => [nama => harga|null]]
|   Harga null = harga produk.
*/

return [
    'image_base' => 'https://nufit.id/wp-content/uploads/',

    // slug => [nama, slug induk|null, gambar lanskap|null, deskripsi]
    'categories' => [
        'fashion-apparel' => ['Fashion Apparel', null, '2026/01/6.-running-belt-e1769409231945.jpg', 'Pakaian olahraga NuFit & Nu Shape: legging, jaket anti UV, dan manset.'],
        'pants' => ['Pants', 'fashion-apparel', '2026/01/LEGGING-43.jpg', 'Celana & legging olahraga Nu Shape yang nyaman dan tidak menerawang.'],
        'nu-shape' => ['NU-Shape', null, '2026/01/Nufit-Padel-Club-48-scaled.jpg', 'Nu Shape by Nu Fit: body tape dan nipple cover untuk tampil percaya diri saat beraktivitas.'],
        'running-belt' => ['Running Belt', null, '2025/09/Section-1-BANNER-WEBSITE-1920-X-1000-8.jpg', 'Tas pinggang & running vest untuk menyimpan HP, kunci, dan botol saat lari.'],
        'hat' => ['Hat', null, '2021/12/Nufit-Padel-Club-38-scaled.jpg', 'Topi visor dan headband olahraga yang ringan dan cepat kering.'],
        'socks-n-manset' => ['Socks n Manset', null, '2026/01/DSC01230-scaled.jpg', 'Kaos kaki anti slip untuk yoga, pilates, dan olahraga, plus manset tangan.'],
        'workout' => ['Workout', null, '2021/09/Nufit-Padel-Club-44-scaled.jpg', 'Alat latihan di rumah maupun di gym: pemberat, dumbbell, skipping, dan lainnya.'],
        'yoga' => ['Yoga', null, '2026/01/220-scaled-e1769325183560.jpg', 'Matras dan perlengkapan yoga & pilates.'],
        'support' => ['Support', null, '2026/01/DSC02028-scaled-e1769325788642.jpg', 'Kinesio tape dan cohesive bandage untuk menopang otot & sendi.'],
        'swimming-cap' => ['Swimming Cap', null, '2026/01/260-scaled-e1769324805135.jpg', 'Topi renang silikon premium yang elastis dan anti slip.'],
        'padel' => ['Padel', null, '2021/12/Nufit-Padel-Club-42-scaled.jpg', 'Bola padel bertekanan untuk latihan dan pertandingan.'],
        'water-bottle' => ['Water Bottle', null, '2025/09/soft-flask-10.jpg', 'Soft flask dan kantong air minum yang ringan untuk lari & hiking.'],
        'essentials' => ['Essentials', null, '2026/02/3.jpg', 'Handuk microfiber dan pouch serbaguna untuk tas olahragamu.'],
        'earphones' => ['Earphones', null, '2026/01/Nufit-Padel-Club-54-scaled.jpg', 'Earphone olahraga hasil kolaborasi Nu Fit x VOU.'],
    ],

    // Koleksi = menu "By Collection" di nufit.id: [nama, slug, ikon, warna ubin, tagline, gambar]
    'collections' => [
        ['Runners', 'runners', 'running', 'ink', 'Lari lebih jauh, tetap nyaman', '2025/09/Section-1-BANNER-WEBSITE-1920-X-1000-8.jpg'],
        ['Yoga', 'yoga', 'yoga', null, null, '2026/01/220-scaled-e1769325183560.jpg'],
        ['Pilates', 'pilates', 'yoga', null, null, '2021/12/Nufit-Padel-Club-35-scaled.jpg'],
        ['Workout', 'workout', 'workout', null, null, '2021/09/Nufit-Padel-Club-44-scaled.jpg'],
        ['Padel', 'padel', 'padel', null, null, '2021/12/Nufit-Padel-Club-42-scaled.jpg'],
        ['Hiking', 'hiking', 'hiking', null, null, '2021/12/Nufit-Padel-Club-36-scaled.jpg'],
        ['Swimming', 'swimming', 'swimming', null, null, '2026/01/260-scaled-e1769324805135.jpg'],
        ['Support', 'support', 'support', null, null, '2026/01/DSC02028-scaled-e1769325788642.jpg'],
        ['Fashion Apparel', 'fashion-apparel', 'apparel', null, null, '2026/01/6.-running-belt-e1769409231945.jpg'],
        ['Earphones', 'earphones', 'earphones', null, null, '2026/01/Nufit-Padel-Club-54-scaled.jpg'],
    ],

    'products' => [
        // ── Fashion Apparel ───────────────────────────────────────────
        [
            'name' => 'Nu Shape Aura Flare Yoga Pants',
            'category' => 'pants',
            'collections' => ['fashion-apparel', 'yoga', 'pilates'],
            'price' => 112100,
            'weight' => 250,
            'featured' => true,
            'description' => "Nu Shape by Nu Fit — Aura Collection. Celana flare untuk yoga, pilates, dan aktivitas harian.\n\n• Bahan 82,5% polyamide, 17,5% spandex\n• Tidak menerawang, lembut dan stretch\n• Breathable dengan efek dingin & menyerap keringat\n• Ukuran S, M, L, XL (lihat size chart)",
            'images' => ['2026/01/LEGGING-58.jpg', '2026/01/LEGGING-37.jpg', '2026/01/LEGGING-36.jpg'],
            'variants' => [
                'label' => 'Warna / Ukuran',
                'colors' => [
                    'Black' => ['2026/01/LEGGING-44.jpg'],
                    'Navy' => ['2026/01/LEGGING-43.jpg'],
                    'Purple' => ['2026/01/LEGGING-45.jpg'],
                    'Smoky' => ['2026/01/LEGGING-46.jpg'],
                ],
                'sizes' => ['S' => null, 'M' => null, 'L' => null, 'XL' => null],
            ],
        ],
        [
            'name' => 'Nu Shape Aura Jacket with Hoodie Anti UV SPF 50++',
            'category' => 'fashion-apparel',
            'collections' => ['fashion-apparel', 'runners', 'hiking'],
            'price' => 228000,
            'weight' => 350,
            'featured' => true,
            'description' => "Jaket olahraga ringan dengan hoodie dari Nu Shape Aura Collection.\n\n• Perlindungan sinar UV SPF 50++\n• Bahan adem dan cepat kering, nyaman untuk lari pagi maupun hiking\n• Ukuran S, M, L, XL",
            'images' => ['2026/01/191.jpg', '2026/01/JAKET-17.jpg', '2026/01/JAKET-22.jpg'],
            'variants' => [
                'label' => 'Warna / Ukuran',
                'colors' => [
                    'Black' => ['2026/01/JAKET-10.jpg'],
                    'White' => ['2026/01/JAKET-1.jpg'],
                    'Pink' => ['2026/01/JAKET-5.jpg'],
                ],
                'sizes' => ['S' => null, 'M' => null, 'L' => null, 'XL' => null],
            ],
        ],

        // ── NU-Shape ──────────────────────────────────────────────────
        [
            'name' => 'Nu Shape Boob Tape Transparan dengan Nipple Cover',
            'category' => 'nu-shape',
            'collections' => ['fashion-apparel'],
            'price' => 75000,
            'compare' => 125000,
            'weight' => 80,
            'description' => "Body tape / bra tape transparan dari Nu Shape by Nu Fit, sudah termasuk nipple cover.\n\n• Menopang dan membentuk tanpa tali\n• Anti iritasi, nyaman dipakai seharian\n• Tersedia lebar 5 cm dan 7,5 cm (panjang 5 m)",
            'images' => [],
            'variants' => [
                'label' => 'Ukuran',
                'options' => [
                    ['5 cm x 5 m', 75000, '2026/02/Boob-Tape-6-1.jpg', false, 125000],
                    ['7,5 cm x 5 m', 85000, '2026/02/Boob-Tape-5.jpg', false, 155000],
                ],
            ],
        ],
        [
            'name' => 'Nu Shape Breathable Nipple Cover 8 cm Silicone',
            'category' => 'nu-shape',
            'collections' => ['fashion-apparel'],
            'price' => 49500,
            'compare' => 99000,
            'weight' => 50,
            'description' => "Penutup puting silikon reusable dengan lubang anti keringat.\n\n• Diameter 8 cm, all size\n• Tahan air, anti slip, tampak natural\n• Bisa dicuci dan dipakai berulang kali",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Nude', null, '2026/02/Nipple-Cover-brethable-5.jpg'],
                    ['Olive', null, null],
                    ['Tan', null, '2026/02/Nipple-Cover-brethable-4.jpg'],
                    ['Ivory', null, '2026/02/Nipple-Cover-brethable-11.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Nu Shape Nipple Cover 8 cm Silicone Premium',
            'category' => 'nu-shape',
            'collections' => ['fashion-apparel'],
            'price' => 30500,
            'weight' => 50,
            'description' => "Penutup puting silikon premium anti tembus.\n\n• Diameter 8 cm, all size\n• Reusable, tahan air, anti slip\n• Tampak natural di balik pakaian olahraga",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Nude', null, '2026/02/Nipple-Cover-11.jpg'],
                    ['Olive', null, '2026/02/Nipple-Cover-13-1.jpg'],
                    ['Tan', null, '2026/02/Nipple-Cover-16.jpg'],
                    ['Ivory', null, '2026/02/Nipple-Cover-2-1.jpg'],
                ],
            ],
        ],

        // ── Running Belt ──────────────────────────────────────────────
        [
            'name' => 'Versa Running Belt',
            'category' => 'running-belt',
            'collections' => ['runners', 'hiking'],
            'price' => 78375,
            'weight' => 120,
            'featured' => true,
            'description' => "Running belt yang melingkar pas di pinggang untuk menyimpan HP, kunci, dan kartu selama berlari.\n\n• Tidak memantul saat lari\n• Bahan ringan dan elastis\n• Ukuran S, M, L",
            'images' => ['2026/01/RUNNING-BAG-baru-30.jpg', '2026/01/RUNNING-BAG-baru-26.jpg', '2026/01/RUNNING-BAG-baru-29.jpg', '2026/01/RUNNING-BAG-baru-17.jpg'],
            'variants' => [
                'label' => 'Warna / Ukuran',
                'colors' => [
                    'Black' => ['2026/01/RUNNING-BAG-baru-21.jpg'],
                    'Grey' => ['2026/01/RUNNING-BAG-baru-20.jpg'],
                ],
                'sizes' => ['S' => null, 'M' => null, 'L' => null],
            ],
        ],
        [
            'name' => 'Tas Lari – Tas Pinggang Olahraga',
            'category' => 'running-belt',
            'collections' => ['runners'],
            'price' => 61750,
            'weight' => 100,
            'description' => "Tas pinggang olahraga unisex untuk lari, jalan pagi, maupun bersepeda.\n\n• Muat HP, kunci, dan dompet kecil\n• Tali bisa diatur\n• Ukuran S, M, L",
            'images' => ['2025/08/Tas-lari-wanita-1.5.jpg', '2025/08/Tas-lari-wanita-1.7.jpg', '2025/08/Tas-lari-wanita-1.4.jpg'],
            'variants' => [
                'label' => 'Warna / Ukuran',
                'colors' => [
                    'Hitam' => ['2025/08/Tas-lari-wanita-1.9.jpg'],
                    'Abu' => ['2025/08/Tas-lari-wanita-1.10.jpg'],
                    'Pink' => ['2025/08/Tas-lari-wanita-1.8.jpg'],
                ],
                'sizes' => ['S' => null, 'M' => null, 'L' => null],
            ],
        ],
        [
            'name' => 'Running Vest Hydropack Trail Run',
            'category' => 'running-belt',
            'collections' => ['runners', 'hiking'],
            'price' => 256500,
            'weight' => 300,
            'description' => "Rompi lari / hydropack untuk trail run, marathon, dan hiking.\n\n• Bahan polyester + spandex, pas di badan\n• Kantong depan untuk soft flask dan HP\n• Ukuran S, M, L (harga per 1 pcs)",
            'images' => [],
            'variants' => [
                'label' => 'Ukuran',
                'options' => [
                    ['Hitam / S', null, '2026/02/5-1.jpg'],
                    ['Hitam / M', null, null],
                    ['Hitam / L', null, null],
                ],
            ],
        ],

        // ── Hat ───────────────────────────────────────────────────────
        [
            'name' => 'Lumina Visor Hat UV UPF 50++',
            'category' => 'hat',
            'collections' => ['runners', 'padel'],
            'price' => 90725,
            'weight' => 80,
            'featured' => true,
            'description' => "Topi visor unisex untuk lari, tenis, padel, dan golf.\n\n• Perlindungan UV UPF 50++\n• Bahan 90% polyester fiber, 10% spandex\n• Harga per 1 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', 104500, '2026/02/2.jpg'],
                    ['Putih', 90725, '2026/02/18.jpg'],
                    ['Biru', 90725, '2026/02/16.jpg'],
                    ['Purple', 90725, '2026/02/26.jpg'],
                    ['Pink', 104500, '2026/02/10.jpg'],
                    ['Brown', 104500, '2026/02/7-1.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Topi Olahraga Visor Hat',
            'category' => 'hat',
            'collections' => ['runners', 'padel'],
            'price' => 63650,
            'weight' => 70,
            'description' => "Topi visor olahraga yang ringan untuk lari dan aktivitas luar ruang.\n\n• Bahan polyester, adem dan nyaman dipakai\n• Strap belakang bisa diatur",
            'images' => ['2025/08/imgi_6_id-11134207-7rbkd-m6qpw0raafdtdf.jpeg', '2025/08/imgi_48_id-11134207-7rasj-m5xthpkgtzo33b.jpeg'],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', null, '2025/08/imgi_15_id-11134207-7r991-luapsibhphu73d.jpeg'],
                    ['Putih', null, '2025/08/imgi_19_id-11134207-7r992-luapsibhe92gb4.jpeg'],
                    ['Abu', null, '2025/08/imgi_16_id-11134207-7r98o-luapsibhfnmw96.jpeg'],
                    ['Pink', null, '2025/08/imgi_18_id-11134207-7r98v-luapsibhh27c4a.jpeg'],
                    ['Nude', null, '2025/08/imgi_17_id-11134207-7r98v-lx3ldf54bdl971.jpeg'],
                ],
            ],
        ],
        [
            'name' => 'Headband Yoga / Bandana Olahraga',
            'category' => 'hat',
            'collections' => ['support', 'yoga', 'runners'],
            'price' => 28500,
            'weight' => 30,
            'description' => "Headband elastis untuk menahan keringat dan rambut saat yoga, lari, atau workout.\n\n• Lembut dan tidak licin\n• Harga per 1 pcs",
            'images' => ['2026/01/226-scaled.jpg', '2025/08/imgi_5_id-11134207-7r990-ly6ervo1ipcu44.jpeg'],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', 34675, '2025/08/imgi_14_id-11134207-7r990-luru9u84fsgg6a.jpeg'],
                    ['Biru', null, '2025/08/imgi_16_id-11134207-7r98p-luru9u84h70w7a.jpeg'],
                    ['Abu', null, '2025/08/imgi_17_id-11134207-7r98z-luru9u84k05s94.jpeg'],
                    ['Pink', null, '2025/08/imgi_15_id-11134207-7r98q-luru9u84illcb9.jpeg'],
                ],
            ],
        ],

        // ── Socks n Manset ────────────────────────────────────────────
        [
            'name' => 'Socks Yoga Pilates Anti Slip Tali Silang',
            'category' => 'socks-n-manset',
            'collections' => ['yoga', 'pilates'],
            'price' => 42750,
            'weight' => 60,
            'description' => "Kaos kaki yoga & pilates dengan tali silang dan grip anti licin.\n\n• Cocok untuk yoga, pilates, zumba, ballet, dan senam\n• Bahan lembut, menyerap keringat\n• Harga per 1 pasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', null, '2026/01/YOGA-11.jpg'],
                    ['Abu', null, '2026/01/YOGA-10.jpg'],
                    ['Cream', null, '2026/01/YOGA-13.jpg'],
                    ['Pink', null, '2026/01/YOGA-12.jpg'],
                    ['Purple', null, '2026/01/YOGA-14.jpg'],
                    ['Biru', null, '2026/01/YOGA-9.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Grip Socks Kaos Kaki Antislip',
            'category' => 'socks-n-manset',
            'collections' => ['runners', 'padel', 'pilates'],
            'price' => 45125,
            'weight' => 60,
            'featured' => true,
            'description' => "Kaos kaki ankle unisex dengan grip anti slip untuk running, futsal, basket, tenis, dan padel.\n\n• Grip silikon di telapak\n• Menyerap keringat\n• Harga per 1 pasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', null, '2026/01/LONG-16.jpg'],
                    ['Putih', null, '2026/01/LONG-15.jpg'],
                    ['Abu', null, '2026/01/LONG-18.jpg'],
                    ['Cream', null, null],
                    ['Pink', null, '2026/01/LONG-1.jpg'],
                    ['Purple', null, '2026/01/LONG-20.jpg'],
                    ['Biru', null, '2026/01/LONG-21.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Manset Tangan Unisex Handsock Jempol',
            'category' => 'socks-n-manset',
            'collections' => ['runners', 'hiking', 'fashion-apparel'],
            'price' => 33250,
            'weight' => 50,
            'description' => "Manset lengan panjang dengan lubang jempol untuk lari, bersepeda, dan hiking.\n\n• Melindungi lengan dari sinar matahari\n• Elastis dan adem\n• Harga per 1 pasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', 41800, '2025/08/manset-12.jpg'],
                    ['Putih', null, '2025/08/manset-3.jpg'],
                    ['Nude', null, '2025/08/manset-5.jpg'],
                ],
            ],
        ],

        // ── Workout ───────────────────────────────────────────────────
        [
            'name' => 'Adjustable Wrist & Ankle Weight Bangles 1 kg [Free Pouch]',
            'category' => 'workout',
            'collections' => ['workout', 'pilates', 'yoga'],
            'price' => 209000,
            'weight' => 1100,
            'featured' => true,
            'description' => "Pemberat tangan & kaki berlapis silikon dengan isi besi, untuk melatih kecepatan, kekuatan, dan daya tahan otot.\n\n• Berat 1 kg per pcs (2 kg per pasang)\n• Strap bisa diatur 36–55 cm\n• Gratis pouch untuk pembelian sepasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna / Isi',
                'colors' => [
                    'Biru' => ['2026/03/8-6.jpg'],
                    'Abu' => ['2026/03/23.jpg'],
                    'Pink' => ['2026/03/42-1.jpg'],
                    'Purple' => ['2026/03/15.jpg'],
                    'Mocca' => ['2026/03/35.jpg'],
                ],
                'sizes' => ['1 kg (satuan)' => 209000, '2 kg (sepasang)' => 408500],
            ],
        ],
        [
            'name' => 'Adjustable Ankle Weight Bangles 0,5 kg [Free Pouch]',
            'category' => 'workout',
            'collections' => ['workout', 'yoga', 'hiking'],
            'price' => 121125,
            'weight' => 600,
            'description' => "Versi lebih ringan dari weight bangles NuFit, pas untuk pergelangan kaki.\n\n• Berat 0,5 kg per pcs (1 kg per pasang)\n• Strap 28–33 cm, bantalan silikon lebih ramping\n• Gratis pouch untuk pembelian sepasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna / Isi',
                'colors' => [
                    'Biru' => ['2026/03/blue-5-2.jpg'],
                    'Abu' => ['2026/03/26-1.jpg'],
                    'Pink' => ['2026/03/pink-7-1.jpg'],
                    'Purple' => ['2026/03/purple-6.jpg', null, true],
                    'Mocca' => [null],
                ],
                'sizes' => ['0,5 kg (satuan)' => 121125, '1 kg (sepasang)' => 223155],
            ],
        ],
        [
            'name' => 'Magnetic Ankle Weight Nu Fit Original Design',
            'category' => 'workout',
            'collections' => ['workout', 'yoga', 'pilates'],
            'price' => 356500,
            'weight' => 2300,
            'description' => "Pemberat tangan & kaki desain original NuFit dengan pengait magnet.\n\n• Bahan silikon premium dan stainless steel\n• Mudah dipasang dan dilepas\n• Dijual sepasang",
            'images' => [],
            'variants' => [
                'label' => 'Warna / Berat',
                'options' => [
                    ['Navy – 1 kg sepasang', 356500, '2026/02/biruuu-2.jpg'],
                    ['Purple Pink – 1 kg sepasang', 356500, '2026/02/pinkk-2.jpg'],
                    ['Black Grey – 2 kg sepasang', 522500, '2026/02/hitamm-1.jpg'],
                    ['Mocca Cream – 2 kg sepasang', 522500, '2026/02/brown-1.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Weight Bar Premium – Dumbbell Mini Non Slip [Free Pouch]',
            'category' => 'workout',
            'collections' => ['workout', 'pilates'],
            'price' => 166250,
            'weight' => 2200,
            'description' => "Dumbbell mini berlapis neoprene/silikon yang tidak licin, fleksibel untuk berbagai latihan di rumah.\n\n• Genggaman ergonomis\n• Cocok untuk pilates, toning, dan latihan beban ringan",
            'images' => [],
            'variants' => [
                'label' => 'Berat',
                'options' => [
                    ['1 kg – Pink', 166250, '2026/03/6-3.jpg', true],
                    ['2 kg – Biru', 189500, '2026/03/WEIGHT-BAR-2KG-2-2.jpg'],
                    ['3 kg set 2 pcs – Purple', 289750, '2026/03/2-2.jpg', true],
                ],
            ],
        ],
        [
            'name' => 'Push Up Dumbbell Silicone U Shape 3 kg',
            'category' => 'workout',
            'collections' => ['workout'],
            'price' => 285000,
            'weight' => 3200,
            'description' => "Dumbbell bentuk U berlapis silikon yang juga bisa dipakai sebagai push up bar dan plank bar.\n\n• Berat 3 kg\n• Permukaan non slip\n• Multifungsi untuk latihan tubuh atas",
            'images' => ['2026/02/U-shape-Dumbbell-7.jpg'],
        ],
        [
            'name' => 'Thigh Master Original – Leg Trainer',
            'category' => 'workout',
            'collections' => ['workout', 'pilates'],
            'price' => 80750,
            'weight' => 600,
            'description' => "Alat latihan untuk mengencangkan otot paha, panggul, tangan, dan dada; bisa dipakai untuk senam kegel.\n\n• Aman untuk berbagai kalangan, termasuk ibu hamil\n• Tersedia versi dengan penghitung (counting)",
            'images' => [],
            'variants' => [
                'label' => 'Tipe / Warna',
                'options' => [
                    ['No Counting – Blue', 80750, '2026/02/THGH-MASTER-4.jpg', true],
                    ['No Counting – Purple', 80750, '2026/02/THGH-MASTER-5.jpg', true],
                    ['No Counting – Pink', 80750, '2026/02/THGH-MASTER-6.jpg', true],
                    ['With Counting – Blue', 95000, '2026/02/blue-1.jpg', true],
                    ['With Counting – Purple', 95000, '2026/02/purple-2.jpg', true],
                    ['With Counting – Pink', 95000, '2026/02/THGH-MASTER-WITH-COUNT-4.jpg', true],
                ],
            ],
        ],
        [
            'name' => 'Core Slider Round (1 Set isi 2 Pcs)',
            'category' => 'workout',
            'collections' => ['workout', 'pilates', 'yoga'],
            'price' => 71250,
            'weight' => 300,
            'description' => "Sliding disc untuk latihan core dengan berat tubuh di rumah.\n\n• Bisa dipakai di lantai keramik maupun karpet\n• 1 set isi 2 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Pink', null, '2026/02/CORE-SLIDER-PINK2.png'],
                    ['Abu', null, '2026/02/CORE-SLIDER-ABU2.png'],
                ],
            ],
        ],
        [
            'name' => 'Resistance Hip Band Kain (1 Set isi 3 Pcs)',
            'category' => 'workout',
            'collections' => ['workout', 'pilates', 'yoga'],
            'price' => 145350,
            'weight' => 300,
            'description' => "Hip band / booty band berbahan kain non slip untuk squat, glute bridge, dan latihan kaki.\n\n• Tidak menggulung dan tidak licin\n• 1 set isi 3 pcs dengan tingkat tahanan berbeda",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Abu Set', null, '2026/03/WhatsApp-Image-2026-03-01-at-11.07.34-AM.jpeg'],
                    ['Pastel', null, '2026/03/pastel.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Foam Jump Rope – Skipping Premium',
            'category' => 'workout',
            'collections' => ['workout'],
            'price' => 69825,
            'weight' => 250,
            'description' => "Tali skipping dengan gagang foam yang nyaman digenggam.\n\n• Gagang PP dengan lapisan foam\n• Tali PVC, panjang bisa disesuaikan\n• Harga per 1 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Abu', null, '2026/02/abu-3.jpg'],
                    ['Pink', null, '2026/02/pink-5-1.jpg'],
                    ['Biru', null, '2026/02/biru-3.jpg', true],
                    ['Hijau', null, '2026/02/hijau-1-2.jpg', true],
                ],
            ],
        ],
        [
            'name' => 'Original Nü-stix Ripstix – Poundfit Stick',
            'category' => 'workout',
            'collections' => ['workout'],
            'price' => 65455,
            'weight' => 300,
            'description' => "Stik poundfit original Nü-stix by Nu Fit untuk kelas cardio drumming dan workout yang seru.\n\n• Ringan dan kuat\n• Dijual sepasang",
            'images' => ['2025/08/nu-Stix-1.7.jpeg', '2025/08/nu-Stix-1.2.jpeg', '2025/08/nu-Stix-1.1.jpeg'],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Pink', null, '2026/02/ripstick-pink-4.jpg'],
                    ['Hijau', null, '2026/02/ripstick-hijau-2.jpg'],
                ],
            ],
        ],

        // ── Yoga ──────────────────────────────────────────────────────
        [
            'name' => 'Matras Yoga TPE 183 x 61 x 6 mm Anti Slip',
            'category' => 'yoga',
            'collections' => ['yoga', 'pilates'],
            'price' => 185250,
            'weight' => 900,
            'featured' => true,
            'description' => "Matras yoga & pilates berbahan TPE yang ringan, empuk, dan anti slip.\n\n• Ukuran 183 x 61 cm, tebal 6 mm\n• Mudah digulung dan dibawa\n• Harga per 1 pcs",
            'images' => ['2025/08/imgi_70_id.jpg', '2025/08/imgi_2_id-.jpg'],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Abu', null, '2026/03/abu-3-copy.jpg'],
                    ['Light Blue', null, '2026/03/light-blue-3.jpg'],
                    ['Ungu', null, '2026/03/ungu-2.jpg'],
                    ['Pink', null, '2026/03/ungu-1-1.jpg', true],
                ],
            ],
        ],
        [
            'name' => 'Yoga Knee Pad – Alas Lutut Yoga',
            'category' => 'yoga',
            'collections' => ['yoga', 'pilates'],
            'price' => 40375,
            'weight' => 200,
            'description' => "Bantalan empuk untuk lutut, siku, dan tangan saat yoga & pilates.\n\n• Mengurangi tekanan di lantai keras\n• Tersedia satuan atau 1 set isi 2 pcs",
            'images' => ['2026/02/biru-1-1.jpg', '2026/02/id-11134207-7r98y-ly6av6bw80tkb3.jpg'],
            'variants' => [
                'label' => 'Warna / Isi',
                'colors' => [
                    'Black' => ['2026/02/hitam-2.jpg'],
                    'Biru' => ['2026/02/biru-5.jpg'],
                    'Pink' => ['2026/02/pink-3.jpg'],
                    'Purple' => ['2026/02/ungu-1.jpg'],
                ],
                'sizes' => ['Satuan' => 40375, '1 Set (2 pcs)' => 78375],
            ],
        ],

        // ── Support ───────────────────────────────────────────────────
        [
            'name' => 'Kinesiologi Tape 5 cm x 5 m',
            'category' => 'support',
            'collections' => ['support', 'runners', 'workout'],
            'price' => 41800,
            'weight' => 60,
            'featured' => true,
            'description' => "Kinesio tape elastis untuk menopang otot dan sendi saat olahraga.\n\n• Ukuran 5 cm x 5 m\n• Lentur mengikuti gerak tubuh\n• Cocok untuk lari, fitness, dan pemulihan cedera ringan",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Skin', null, '2026/01/KINE-6.jpg'],
                    ['Biru', null, '2026/01/KINE-14.jpg'],
                    ['Pink', null, '2026/01/KINE-5.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Cohesive Bandage 5 cm x 4,5 m – Perban Elastis',
            'category' => 'support',
            'collections' => ['support', 'workout', 'hiking'],
            'price' => 19000,
            'weight' => 40,
            'description' => "Perban elastis self-adhesive yang menempel pada dirinya sendiri tanpa lem.\n\n• Tidak lengket di kulit atau rambut\n• Bisa dipakai sebagai finger tape / wrist tape\n• Ukuran 5 cm x 4,5 m",
            'images' => [],
            'variants' => [
                'label' => 'Warna / Motif',
                'options' => [
                    ['Black', null, '2026/02/black-4.jpg'],
                    ['White', null, '2026/02/white-9.jpg'],
                    ['Nude', null, '2026/02/nude-5.jpg'],
                    ['Pink', null, '2026/02/pink-4-1.jpg'],
                    ['Blue', null, '2026/02/blue-1-1.jpg'],
                    ['Motif Army', null, '2026/02/war-camo-3.jpg'],
                    ['Motif Ocean Blue', null, '2026/02/ocean-blue-9.jpg'],
                    ['Motif Snow White', null, '2026/02/snow-white-4.jpg'],
                    ['Motif Panda', null, '2026/02/panda-4.jpg'],
                    ['Motif Peach', null, '2026/02/peach-4.jpg'],
                ],
            ],
        ],

        // ── Swimming Cap ──────────────────────────────────────────────
        [
            'name' => 'Silicone Swimming Cap – Topi Renang Silikon Premium',
            'category' => 'swimming-cap',
            'collections' => ['swimming'],
            'price' => 38000,
            'weight' => 80,
            'featured' => true,
            'description' => "Topi renang silikon premium untuk dewasa.\n\n• Anti slip dan waterproof\n• Elastis, tidak menjepit kepala\n• Melindungi rambut dari kaporit",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', 42750, '2026/01/SWIMMING-CAP-2.jpg'],
                    ['White', 40375, '2026/01/SWIMMING-CAP-1.jpg'],
                    ['Blue', null, '2026/01/SWIMMING-CAP-3.jpg'],
                    ['Pink', null, '2026/01/SWIMMING-CAP-4.jpg'],
                    ['Purple', null, '2026/01/SWIMMING-CAP-4-1.jpg'],
                ],
            ],
        ],

        // ── Padel ─────────────────────────────────────────────────────
        [
            'name' => 'Bola Padel Isi 3 – Pressurized Padel Ball',
            'category' => 'padel',
            'collections' => ['padel'],
            'price' => 75905,
            'weight' => 200,
            'featured' => true,
            'description' => "Bola padel bertekanan, isi 3 per tabung, untuk latihan maupun pertandingan.\n\n• Pantulan konsisten\n• Tersedia versi Pro dan edisi Pink",
            'images' => [],
            'variants' => [
                'label' => 'Tipe',
                'options' => [
                    ['Padel Ball', 75905, '2025/09/imgi_8_id-11134207-7ra0o-mca5qdjn8k4e99.jpg'],
                    ['Padel Ball Pink', 85405, '2026/01/232-scaled.jpg'],
                    ['Padel Ball Pro', 90250, '2026/01/230-scaled.jpg'],
                ],
            ],
        ],

        // ── Water Bottle ──────────────────────────────────────────────
        [
            'name' => 'Botol Minum Lipat 500 ml – Foldable Soft Flask',
            'category' => 'water-bottle',
            'collections' => ['runners', 'hiking'],
            'price' => 61750,
            'weight' => 60,
            'description' => "Soft flask 500 ml yang bisa dilipat saat kosong, pas di kantong running vest.\n\n• Ringan dan hemat tempat\n• Cocok untuk trail running dan hiking",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', null, '2025/08/soft-flask-4.jpg'],
                    ['Putih', null, '2025/09/soft-flask-10.jpg'],
                    ['Biru', null, '2025/08/soft-flask-2.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Kantong Air Minum Water Bladder 2 L',
            'category' => 'water-bottle',
            'collections' => ['hiking', 'runners'],
            'price' => 99750,
            'weight' => 200,
            'description' => "Water bladder 2 liter untuk running vest atau tas hiking.\n\n• Selang minum praktis tanpa perlu berhenti\n• Harga per 1 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Hitam', null, '2025/08/Kantong-Minum-2L-1.3.jpeg'],
                    ['Putih', null, '2025/08/Kantong-Minum-2L-1.5.jpeg'],
                ],
            ],
        ],

        // ── Essentials ────────────────────────────────────────────────
        [
            'name' => 'Handuk Olahraga Microfiber Quick Dry',
            'category' => 'essentials',
            'collections' => ['workout', 'yoga', 'pilates'],
            'price' => 57000,
            'weight' => 100,
            'description' => "Handuk olahraga microfiber yang cepat kering untuk gym, lari, dan traveling.\n\n• Bahan microfiber (88% polyester, 12% polyamide)\n• Ringan dan menyerap keringat\n• Harga per 1 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Pink', null, '2026/02/1-2.jpg'],
                    ['Biru', null, '2026/02/2-1.jpg'],
                ],
            ],
        ],
        [
            'name' => 'Handuk Microfiber Jumbo Quick Dry',
            'category' => 'essentials',
            'collections' => ['workout', 'swimming'],
            'price' => 109250,
            'weight' => 250,
            'description' => "Handuk microfiber ukuran jumbo untuk renang, gym, dan traveling.\n\n• Bahan microfiber (88% polyester, 12% polyamide)\n• Cepat kering, ringkas dilipat\n• Harga per 1 pcs",
            'images' => [],
            'variants' => [
                'label' => 'Warna',
                'options' => [
                    ['Abu', null, '2026/02/3.jpg'],
                    ['Pink', null, '2026/02/9-2.jpg', true],
                ],
            ],
        ],
        [
            'name' => 'Travel Pouch Make Up Organizer',
            'category' => 'essentials',
            'collections' => ['swimming', 'hiking', 'workout', 'yoga'],
            'price' => 19000,
            'weight' => 30,
            'description' => "Pouch serut serbaguna untuk merapikan barang kecil di tas olahraga atau saat traveling.\n\n• Ukuran 21 x 24 cm\n• Warna hitam\n• Harga per 1 pcs",
            'images' => ['2026/03/nu-fit-322.png'],
        ],

        // ── Earphones ─────────────────────────────────────────────────
        [
            'name' => 'Nu Fit x VOU Bone Conduction Headphone Bluetooth',
            'category' => 'earphones',
            'collections' => ['earphones', 'runners'],
            'price' => 536750,
            'weight' => 200,
            'description' => "Headphone olahraga bone conduction hasil kolaborasi Nu Fit x VOU. Suara dihantarkan lewat tulang sehingga telinga tetap terbuka dan kamu tetap waspada dengan sekitar.\n\n• Bluetooth 5.3, desain open ear\n• Tahan keringat IPX5\n• Warna hitam",
            'images' => ['2025/09/imgi_6_id-11134207-7rasi-m2dpf7xu9k8z71.jpg'],
        ],
        [
            'name' => 'Nu Fit x VOU A9 Pro TWS Layar LCD Touchscreen',
            'category' => 'earphones',
            'collections' => ['earphones'],
            'price' => 175750,
            'weight' => 150,
            'description' => "Earphone TWS dengan case berlayar LCD touchscreen.\n\n• Bluetooth 5.4\n• Peredam bising ANC/ENC\n• Warna putih",
            'images' => ['2026/01/224-scaled.jpg'],
        ],
    ],
];
