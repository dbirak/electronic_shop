<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'main_image' => '1.jpg',
                'additional_images' => json_encode(['1_a.jpg', '1_b.jpg', '1_c.jpg']),
            ],
            [
                'main_image' => '2.jpg',
                'additional_images' => json_encode(['2_a.jpg', '2_b.jpg']),
            ],
            [
                'main_image' => '3.jpg',
                'additional_images' => json_encode(['3_a.jpg']),
            ],
            [
                'main_image' => '4.jpg',
                'additional_images' => json_encode(['4_a.jpg', '4_b.jpg']),
            ],
            [
                'main_image' => '5.jpg',
                'additional_images' => json_encode(['5_a.jpg', '5_b.jpg', '5_c.jpg']),
            ],
            [
                'main_image' => '6.jpg',
                'additional_images' => json_encode(['6_a.jpg']),
            ],
            [
                'main_image' => '7.jpg',
                'additional_images' => json_encode(['7_a.jpg', '7_b.jpg']),
            ],
            [
                'main_image' => '8.jpg',
                'additional_images' => json_encode(['8_a.jpg', '8_b.jpg']),
            ],
            [
                'main_image' => '9.jpg',
                'additional_images' => json_encode(['9_a.jpg']),
            ],
            [
                'main_image' => '10.jpg',
                'additional_images' => json_encode(['10_a.jpg', '10_b.jpg', '10_c.jpg']),
            ],
            [
                'main_image' => '11.jpg',
                'additional_images' => json_encode(['11_a.jpg', '11_b.jpg']),
            ],
            [
                'main_image' => '12.jpg',
                'additional_images' => json_encode(['12_a.jpg']),
            ],
            [
                'main_image' => '13.jpg',
                'additional_images' => json_encode(['13_a.jpg', '13_b.jpg', '13_c.jpg']),
            ],
            [
                'main_image' => '14.jpg',
                'additional_images' => json_encode(['14_a.jpg', '14_b.jpg']),
            ],
            [
                'main_image' => '15.jpg',
                'additional_images' => json_encode(['15_a.jpg']),
            ],
        ]);
    }
}
