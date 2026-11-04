<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Mengisi data contoh hanya bila tabel items masih kosong,
     * supaya container yang dijalankan ulang tidak menggandakan data.
     */
    public function run(): void
    {
        if (Item::exists()) {
            return;
        }

        foreach ([
            ['name' => 'Nasi Goreng', 'description' => 'Nasi goreng spesial telur'],
            ['name' => 'Bakwan', 'description' => 'Bakwan sayur goreng'],
            ['name' => 'Es Teh', 'description' => 'Teh manis dingin'],
            ['name' => 'Ayam Geprek', 'description' => 'Ayam goreng sambal bawang'],
        ] as $item) {
            Item::create($item);
        }
    }
}
