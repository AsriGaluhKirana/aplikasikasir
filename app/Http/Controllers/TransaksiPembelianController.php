<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembelian;
use App\Http\Requests\StoreTransaksiPembelianRequest;
use App\Http\Requests\UpdateTransaksiPembelianRequest;

class TransaksiPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTransaksiPembelianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiPembelianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPembelian  $transaksiPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPembelian $transaksiPembelian, $id)
    {
        return response()->json($transaksiPembelian->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPembelian  $transaksiPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPembelian $transaksiPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiPembelianRequest  $request
     * @param  \App\Models\TransaksiPembelian  $transaksiPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiPembelianRequest $request, TransaksiPembelian $transaksiPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPembelian  $transaksiPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPembelian $transaksiPembelian)
    {
        //
    }
}
