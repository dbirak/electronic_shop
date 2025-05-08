<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Laptopy'],
            ['name' => 'Komputery PC'],
            ['name' => 'Smartfony'],
            ['name' => 'Tablety'],
            ['name' => 'Monitory'],
            ['name' => 'Podzespoły komputerowe'],
            ['name' => 'Karty graficzne'],
            ['name' => 'Płyty główne'],
            ['name' => 'Pamięci RAM'],
            ['name' => 'Dyski SSD'],
            ['name' => 'Zasilacze'],
            ['name' => 'Obudowy'],
            ['name' => 'Słuchawki'],
            ['name' => 'Myszki'],
            ['name' => 'Klawiatury'],
            ['name' => 'Drukarki'],
            ['name' => 'Telewizory'],
            ['name' => 'Konsole i gry'],
            ['name' => 'Smartwatche'],
            ['name' => 'Akcesoria komputerowe'],
        ]);
    }
}
