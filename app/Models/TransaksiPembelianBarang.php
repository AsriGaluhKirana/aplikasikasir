<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelianBarang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaksiPembelian()
    {
        return $this->hasOne(TransaksiPembelian::class, 'id', 'transaksi_pembelian_id');
    }

    public function masterBarang()
    {
        return $this->hasOne(MasterBarang::class, 'id', 'master_barang_id');
    }
}
