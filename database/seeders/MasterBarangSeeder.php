<?php

namespace Database\Seeders;

use App\Models\MasterBarang;
use Illuminate\Database\Seeder;

class MasterBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama_barang = [
            [
                'nama_barang' => 'Sabun Batang',
                'harga_satuan' => 3000,
            ],
            [
                'nama_barang' => 'Mie Instan',
                'harga_satuan' => 2000,
            ],
            [
                'nama_barang' => 'Pensil',
                'harga_satuan' => 1000,
            ],
            [
                'nama_barang' => 'Kopi Sachet',
                'harga_satuan' => 1500,
            ],
            [
                'nama_barang' => 'Air Minum Galon',
                'harga_satuan' => 20000,
            ],
        ];

        $length = count(($nama_barang));

        for($i = 0; $i < $length ;$i++){
            MasterBarang::create([
                'nama_barang' => $nama_barang[$i]['nama_barang'],
                'harga_satuan' => $nama_barang[$i]['harga_satuan']
            ]);
        }
    }
}
