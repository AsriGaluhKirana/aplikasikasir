<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaksiPembelianBarang()
    {
        return $this->hasMany(TransaksiPembelianBarang::class, 'transaksi_pembelian_id', 'id');
    }
}
