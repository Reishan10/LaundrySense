@extends('layouts.main')
@section('title', 'Transaksi')
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('beranda.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                    <h4 class="page-title">@yield('title')</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="form">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="pelanggan" class="form-label">Pelanggan</label>
                                <select name="pelanggan" id="pelanggan" class="form-control">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @forelse ($user as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @empty
                                        <option value="">Data Tidak Tersedia</option>
                                    @endforelse
                                </select>
                                <div class="invalid-feedback errorPelanggan"></div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="jenis_pakaian" class="form-label">Jenis Pakaian</label>
                                            <select name="jenis_pakaian" id="jenis_pakaian" class="form-control">
                                                <option value="">-- Pilih Jenis --</option>
                                                @forelse ($jenis as $row)
                                                    <option value="{{ $row->id }}">{{ $row->jenis_pakaian }}</option>
                                                @empty
                                                    <option value="">Data Tidak Tersedia</option>
                                                @endforelse
                                            </select>
                                            <div class="invalid-feedback errorJenisPakaian"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="text" name="harga" id="harga" class="form-control"
                                                readonly>
                                            <div class="invalid-feedback errorHarga"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="berat" class="form-label">Berat (Kg)</label>
                                            <input type="number" name="berat" id="berat" class="form-control"
                                                value="0">
                                            <div class="invalid-feedback errorBerat"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="jumlah" class="form-label">Total Harga</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" value="0"
                                                readonly>
                                            <div class="invalid-feedback errorJumlah"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control">
                                        <div class="invalid-feedback errorTanggalMulai"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                                        <div class="invalid-feedback errorTanggalSelesai"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary mb-2"
                                    onclick="window.location='{{ route('transaksi.index') }}'">Kembali</button>
                                <button type="submit" class="btn btn-primary mb-2" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    </div>

    <script>
        $(document).ready(function() {
            $('#jenis_pakaian').on('change', function() {
                // Mengambil ID jenis pakaian yang dipilih
                var jenisPakaianId = $(this).val();

                // Mengirim permintaan Ajax untuk mengambil harga
                $.ajax({
                    url: '/transaksi/get-harga', // Ubah sesuai dengan URL endpoint Anda
                    type: 'GET',
                    data: {
                        jenis_pakaian_id: jenisPakaianId
                    },
                    success: function(response) {
                        // Menampilkan harga di dalam input harga
                        $('#harga').val(response.harga);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('#berat, #jenis_pakaian').on('input', function() {
                // Mengambil nilai berat dan harga
                var berat = parseFloat($('#berat').val());
                var harga = parseFloat($('#harga').val());

                // Mengalikan berat dengan harga
                var total = berat * harga;

                // Memasukkan nilai total ke dalam input jumlah
                $('#jumlah').val(total.toFixed(3));
            });
        });

        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('transaksi.store') }}",
                type: "POST",
                dataType: 'json',
                beforeSend: function() {
                    $('#simpan').attr('disabled', 'disabled');
                    $('#simpan').text('Proses...');
                },
                complete: function() {
                    $('#simpan').removeAttr('disabled');
                    $('#simpan').html('Simpan');
                },
                success: function(response) {
                    if (response.errors) {
                        if (response.errors.pelanggan) {
                            $('#pelanggan').addClass('is-invalid');
                            $('.errorPelanggan').html(response.errors.pelanggan);
                        } else {
                            $('#pelanggan').removeClass('is-invalid');
                            $('.errorPelanggan').html('');
                        }

                        if (response.errors.berat) {
                            $('#berat').addClass('is-invalid');
                            $('.errorBerat').html(response.errors.berat);
                        } else {
                            $('#berat').removeClass('is-invalid');
                            $('.errorBerat').html('');
                        }

                        if (response.errors.jenis_pakaian) {
                            $('#jenis_pakaian').addClass('is-invalid');
                            $('.errorJenisPakaian').html(response.errors.jenis_pakaian);
                        } else {
                            $('#jenis_pakaian').removeClass('is-invalid');
                            $('.errorJenisPakaian').html('');
                        }

                        if (response.errors.jumlah) {
                            $('#jumlah').addClass('is-invalid');
                            $('.errorJumlah').html(response.errors.jumlah);
                        } else {
                            $('#jumlah').removeClass('is-invalid');
                            $('.errorJumlah').html('');
                        }

                        if (response.errors.tgl_mulai) {
                            $('#tgl_mulai').addClass('is-invalid');
                            $('.errorTanggalMulai').html(response.errors.tgl_mulai);
                        } else {
                            $('#tgl_mulai').removeClass('is-invalid');
                            $('.errorTanggalMulai').html('');
                        }

                        if (response.errors.tgl_selesai) {
                            $('#tgl_selesai').addClass('is-invalid');
                            $('.errorTanggalSelesai').html(response.errors.tgl_selesai);
                        } else {
                            $('#tgl_selesai').removeClass('is-invalid');
                            $('.errorTanggalSelesai').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.success,
                        }).then(function() {
                            top.location.href =
                                "{{ route('transaksi.index') }}";
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
        });
    </script>
@endsection
