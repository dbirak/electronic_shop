<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop Lenovo Legion 5',
                'description' => 'Wydajny laptop gamingowy z procesorem AMD Ryzen 7 i kartą RTX 3060.',
                'price' => 4899.00,
                'promotion_id' => null,
                'image_id' => 1,
                'category_id' => 1,
            ],
            [
                'name' => 'Komputer PC Actina AMD Ryzen 5',
                'description' => 'Gotowy zestaw do gier z kartą GeForce RTX i szybkim SSD.',
                'price' => 3899.00,
                'promotion_id' => null,
                'image_id' => 2,
                'category_id' => 2,
            ],
            [
                'name' => 'Smartfon Samsung Galaxy S23',
                'description' => 'Flagowiec z potrójnym aparatem i ekranem AMOLED 120 Hz.',
                'price' => 3599.00,
                'promotion_id' => null,
                'image_id' => 3,
                'category_id' => 3,
            ],
            [
                'name' => 'Tablet Apple iPad Air',
                'description' => 'Lekki i szybki tablet z procesorem Apple M1 i wsparciem dla Apple Pencil.',
                'price' => 2899.00,
                'promotion_id' => null,
                'image_id' => 4,
                'category_id' => 4,
            ],
            [
                'name' => 'Monitor LG UltraGear 27"',
                'description' => 'Monitor do gier z odświeżaniem 144 Hz i matrycą IPS.',
                'price' => 1299.00,
                'promotion_id' => null,
                'image_id' => 5,
                'category_id' => 5,
            ],
            [
                'name' => 'Procesor Intel Core i7-13700K',
                'description' => 'Wydajny procesor 13. generacji idealny do gamingu i pracy.',
                'price' => 1899.00,
                'promotion_id' => null,
                'image_id' => 6,
                'category_id' => 6,
            ],
            [
                'name' => 'Karta graficzna NVIDIA RTX 4070 Ti',
                'description' => 'Wysoka wydajność w grach 4K, DLSS 3 i ray tracing.',
                'price' => 4199.00,
                'promotion_id' => null,
                'image_id' => 7,
                'category_id' => 7,
            ],
            [
                'name' => 'Płyta główna MSI B550 TOMAHAWK',
                'description' => 'Stabilna płyta główna do Ryzenów z obsługą PCIe 4.0.',
                'price' => 699.00,
                'promotion_id' => null,
                'image_id' => 8,
                'category_id' => 8,
            ],
            [
                'name' => 'Pamięć RAM Kingston Fury 16GB DDR4',
                'description' => 'Szybka pamięć RAM o taktowaniu 3200 MHz.',
                'price' => 229.00,
                'promotion_id' => null,
                'image_id' => 9,
                'category_id' => 9,
            ],
            [
                'name' => 'Dysk SSD Samsung 980 1TB NVMe',
                'description' => 'Bardzo szybki dysk NVMe do gier i pracy.',
                'price' => 399.00,
                'promotion_id' => null,
                'image_id' => 10,
                'category_id' => 10,
            ],
            [
                'name' => 'Zasilacz be quiet! Pure Power 11 600W',
                'description' => 'Cichy i niezawodny zasilacz z certyfikatem 80+ Gold.',
                'price' => 319.00,
                'promotion_id' => null,
                'image_id' => 11,
                'category_id' => 11,
            ],
            [
                'name' => 'Obudowa SilentiumPC Ventum VT4',
                'description' => 'Przestronna obudowa z dobrą wentylacją.',
                'price' => 189.00,
                'promotion_id' => null,
                'image_id' => 12,
                'category_id' => 12,
            ],
            [
                'name' => 'Słuchawki SteelSeries Arctis 7',
                'description' => 'Bezprzewodowe słuchawki gamingowe z dźwiękiem przestrzennym.',
                'price' => 649.00,
                'promotion_id' => null,
                'image_id' => 13,
                'category_id' => 13,
            ],
            [
                'name' => 'Myszka Logitech G502 Hero',
                'description' => 'Precyzyjna mysz z możliwością konfiguracji przycisków.',
                'price' => 249.00,
                'promotion_id' => null,
                'image_id' => 14,
                'category_id' => 14,
            ],
            [
                'name' => 'Klawiatura mechaniczna HyperX Alloy',
                'description' => 'Wytrzymała klawiatura z podświetleniem RGB.',
                'price' => 399.00,
                'promotion_id' => null,
                'image_id' => 15,
                'category_id' => 15,
            ],
        ]);
    }
}
