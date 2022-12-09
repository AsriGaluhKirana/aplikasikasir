@extends('layouts.main')

@section('content')
<div class="container pb-5">
    <h1 class="mb-2 text-center">Daftar Transaksi</h1>
    <div class="row">
        <div class="col-12">
            <div class="row-12">
                <div class="card shadow-sm p-4">
                    <h4 class="text-center mb-4 text-center">Transaksi</h4>
                    <div class="form-group">
                        <label for="search">ID Transaksi</label>
                        {{-- <input type="number" class="form-control" id="id_transaksi" placeholder="Search ID Transaksi" autocomplete="off"> --}}
                        <select class="custom-select" id="id_transaksi">
                            <option selected disabled>Select ID Transaksi</option>
                            @foreach ($all_transaksi as $transaksi)
                                <option value="{{ $transaksi->id }}">{{ $transaksi->id }}</option>
                            @endforeach
                          </select>
                        <button type="button" id="submit" class="btn btn-primary mt-2 d-flex ml-auto">Search</button>
                    </div>
                </div>
            </div>
            <div class="row-12">
                <div class="card shadow-sm p-4 mt-2" id="detailTransaksi" hidden>
                    <div>
                        <ul id="listBarang"></ul>
                    </div>
                    <hr>
                    <div>
                        <h5 id="totalTransaksi"></h5>
                        <h5 id="waktuTransaksi"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 card p-4  shadow-sm">
        <table class="table table-hover" id="tableTransaksi">
            <thead>
              <tr>
                <th scope="col">ID Transaksi</th>
                <th scope="col">Waktu Transaksi</th>
                <th scope="col">Total Harga</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($all_transaksi as $transaksi)
                    <tr>
                        <th scope="row">{{ $transaksi->id }}</th>
                        <td>{{ $transaksi->created_at }}</td>
                        <td>{{ "Rp " . number_format($transaksi->total_harga,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>
</div>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('#tableTransaksi').DataTable({
        order : true
    });
</script>

<script>
    const formatRupiah = (angka) => {
        let	number_string = angka.toString(),
            sisa 	= number_string.length % 3,
            rupiah 	= number_string.substr(0, sisa),
            ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return "Rp " + rupiah;
    }

    $('#submit').click(() => {
        const id = $('#id_transaksi').val();
        const listBarang = $('#listBarang');
        const waktuTransaksi = $('#waktuTransaksi');
        const totalTransaksi = $('#totalTransaksi');
        const detailTransaksi = $('#detailTransaksi');
        detailTransaksi.removeAttr('hidden');
        waktuTransaksi.empty();
        totalTransaksi.empty();
        listBarang.empty();

        $.ajax({
            url : '/transaksi/' + id,
            method : 'GET',
            success : (res) => {
                if(res === 'error'){
                    detailTransaksi.attr('hidden', true);
                    $('#titleBarangDibeli').remove();
                    swal({
                        icon : 'warning',
                        title : 'Data tidak ditemukan!'
                    })
                }
                $.each(res, (index, item) => {
                    $.ajax({
                        url : '/masterbarang/' + item.master_barang_id,
                        success : (res) => {
                            let timestamp = new Date(item.created_at).getTime(),
                                date = new Date(timestamp),
                                year = date.getFullYear(),
                                month = date.getMonth() + 1,
                                day = date.getDate(),
                                hours = date.getHours(),
                                minutes = date.getMinutes(),
                                seconds = date.getSeconds();
                            let tanggalTransaksi = day + "-" + month + "-" + year + " " + hours + ":" + minutes + ":" + seconds;
                            $('#titleBarangDibeli').remove();
                            $(`<h5 id="titleBarangDibeli">Barang yang dibeli :</h5>`).insertBefore(listBarang);
                            listBarang.append(`
                                <li>${res.nama_barang}</li>
                                <h6>Harga : ${formatRupiah(res.harga_satuan)}</h6>
                                <h6>Jumlah : ${item.jumlah}</h6>
                            `)
                            waktuTransaksi.html(`Waktu Transaksi : ${tanggalTransaksi}`)
                        }
                    })
                })
                if(res[0]){
                    $.ajax({
                        url : '/transaksi-pembelian/' + res[0]['transaksi_pembelian_id'],
                        success : (res) => {
                            totalTransaksi.html(`Total Transaksi : ${formatRupiah(res.total_harga)}`)
                        }
                    })
                }
            }
        })
    })
</script>
@endsection
