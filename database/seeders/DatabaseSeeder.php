<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBarang;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        MasterBarang::create([
            'nama_barang' => 'Sabun Batang',
            'harga_satuan' => 3000,
        ]);

        MasterBarang::create([
            'nama_barang' => 'Mie Instan',
            'harga_satuan' => 2000,
        ]);

        MasterBarang::create([
            'nama_barang' => 'Pensil',
            'harga_satuan' => 1000,
        ]);

        MasterBarang::create([
            'nama_barang' => 'Kopi Sachet',
            'harga_satuan' => 1500,
        ]);

        MasterBarang::create([
            'nama_barang' => 'Air Minum Galon',
            'harga_satuan' => 20000,
        ]);
    }
}
