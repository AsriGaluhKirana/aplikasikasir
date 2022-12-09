<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPembelianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pembelian_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_pembelian_id');
            $table->foreignId('master_barang_id');
            $table->string('jumlah');
            $table->string('harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pembelian_barangs');
    }
}
