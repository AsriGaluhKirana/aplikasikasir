<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function transaksiPembelianBarang()
    {
        return $this->hasMany(TransaksiPembelianBarang::class, 'master_barang_id', 'id');
    }
}
