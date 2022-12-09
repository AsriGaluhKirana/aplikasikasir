@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="mb-5 text-center">Data Transaksi</h1>
        <form id="form">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card p-3 shadow-sm">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <label for="nama_barang">Nama Barang</label>
                                    <select class="custom-select mb-3 namaBarang" name="barang_id_0">
                                        <option selected disabled>Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label for="jumlah">Jumlah</label>
                                    <input name="jumlah_0" type="number" class="form-control jumlah" autocomplete="off" min="0">
                                </div>
                            </div>
                            <button type="button" class="badge bg-primary border-0 text-light d-flex ml-auto" id="tambahMenu">tambah</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="buttonSubmit" onclick="handleSubmit()">Submit</button>
                </div>
                <div class="col-4">
                    <div class="card shadow-sm rounded p-4">
                        <h3>Daftar Harga</h3>
                        <select class="custom-select" id="listBarang">
                            <option selected disabled>Select Barang</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                          </select>
                          <h2 class="mt-3" id="hargaBarang"></h2>
                    </div>
                </div>
            </div>
        </form>

    </div>

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

        let angka = 0;
        $('#tambahMenu').click(function(e){
            angka ++;
            $(`
                <div class="row">
                    <div class="col-10">
                        <select class="custom-select mb-3 namaBarang" name="barang_id_${angka}">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <input name="jumlah_${angka}" type="number" class="form-control jumlah">
                    </div>
                </div>
            `).insertBefore(this)
        });

        const handleSubmit = () => {
            const data = $('#form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            console.log(data);
            $.ajax({
                url : '/subtotal',
                method : 'POST',
                data : data,
                success : (res) => {
                    const subTotal = res.subTotal;
                    swal({
                        title: "Total harga : " + formatRupiah(subTotal),
                        text: "Lanjutkan transaksi ini?",
                        icon: "info",
                        buttons: true,
                    }).then((willSubmit) => {
                        if(willSubmit){
                            $.ajax({
                                url : '/transaksi',
                                method : 'POST',
                                data : {
                                    data,
                                    sub_total : subTotal,
                                    "_token" : "{{ csrf_token() }}"
                                },
                                success : (res) => {
                                    if(!res){
                                        swal("Berhasil submit!", {
                                            icon: "success",
                                            timer : 3000
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    }else{
                                        swal("Error!", {
                                            icon: "warning",
                                            title : "Pastikan form diisi dengan lengkap dan benar"
                                        });
                                    }
                                }
                            })
                        }
                    });
                }
            })

        }

        $('#listBarang').change(() => {
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

            const idBarang = $('#listBarang :selected').val();
            $.ajax({
                url : '/masterbarang/' + idBarang,
                success : (res) => {
                    $('#hargaBarang').html(formatRupiah(res.harga_satuan));
                }
            })
        });

    </script>
@endsection
