<?php

use App\Http\Controllers\MasterBarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiPembelianBarangController;
use App\Http\Controllers\TransaksiPembelianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function() {
    $title = "Home";
    return view('home', compact(
        'title'
    ));
});

Route::resource('/transaksi', TransaksiPembelianBarangController::class);
Route::resource('/masterbarang', MasterBarangController::class);
Route::post('/subtotal', [TransaksiPembelianBarangController::class, 'subTotal']);
Route::get('/daftar-transaksi', [TransaksiPembelianBarangController::class, 'daftarTransaksi']);
Route::get('/transaksi-pembelian/{id}', [TransaksiPembelianController::class, 'show']);
