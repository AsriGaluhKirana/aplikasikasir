<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use Illuminate\Http\Request;
use App\Models\TransaksiPembelian;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPembelianBarang;
use App\Http\Requests\StoreTransaksiPembelianBarangRequest;
use App\Http\Requests\UpdateTransaksiPembelianBarangRequest;

class TransaksiPembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Transaksi';

        $barangs = MasterBarang::all();
        return view('transaksi_pembelian_barang.index', compact(
            'title',
            'barangs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiPembelianBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $length = (count($request->data) - 1) / 2;
        $err = [];

        for($i = 0; $i < $length; $i++){
            if(request('data')['barang_id_' . $i] == null){
                return response()->json('error');
            }
            if(request('data')['jumlah_' . $i] == null){
                return response()->json('error');
            }
        }

        DB::beginTransaction();
        $transaksi_pembelian = TransaksiPembelian::create([
            'total_harga' => $request->sub_total
        ]);

        for($i = 0; $i < $length; $i++){
            $master_barang = MasterBarang::find(request("data")['barang_id_' . $i]);

            try{
                TransaksiPembelianBarang::create([
                    'transaksi_pembelian_id' => $transaksi_pembelian->id,
                    'master_barang_id' => $master_barang->id,
                    'jumlah' => request("data")['jumlah_' . $i],
                    'harga_satuan' => $master_barang->harga_satuan
                ]);
            DB::commit();
            }catch(\Exception $e){
            DB::rollBack();
                return response()->json(['err' => $e]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPembelianBarang  $transaksiPembelianBarang
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPembelianBarang $transaksiPembelianBarang, $id)
    {
        $transaksi_pembelian = $transaksiPembelianBarang->where('transaksi_pembelian_id', $id)->get();

        if(count($transaksi_pembelian) > 0){
            return response()->json($transaksi_pembelian);
        }else{
            return response()->json('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPembelianBarang  $transaksiPembelianBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPembelianBarang $transaksiPembelianBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiPembelianBarangRequest  $request
     * @param  \App\Models\TransaksiPembelianBarang  $transaksiPembelianBarang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiPembelianBarangRequest $request, TransaksiPembelianBarang $transaksiPembelianBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPembelianBarang  $transaksiPembelianBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPembelianBarang $transaksiPembelianBarang)
    {
        //
    }

    public function subTotal(Request $request)
    {
        $length = (count($request->all()) - 1) / 2;
        $array_harga = [];

        for($i = 0; $i < $length; $i++){
            $master_barang = new MasterBarang;
            $harga_barang = $master_barang->find(request('barang_id_' . $i))->harga_satuan;
            $jumlah_barang = request('jumlah_' . $i);
            $total = $harga_barang * $jumlah_barang;
            array_push($array_harga, $total);
        }
        $total_harga = array_sum($array_harga);

        return response()->json([
            'subTotal' => $total_harga
        ]);
    }

    public function daftarTransaksi()
    {
        $title = 'Daftar Transaksi Barang';
        $all_transaksi = TransaksiPembelian::all();

        return view('transaksi_pembelian_barang.daftar-transaksi', compact(
            'title',
            'all_transaksi'
        ));
    }
}
