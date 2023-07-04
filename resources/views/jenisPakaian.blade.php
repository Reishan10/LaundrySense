@extends('layouts.main')
@section('title', 'Jenis Pakaian')
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
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-primary btn-sm ms-md-1" id="btnTambah">
                        <i class="mdi mdi-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jenis Pakaian</th>
                                            <th>Harga Perkilo</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
    </div>

    <!-- modal -->
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="jenis_pakaian" class="form-label">Jenis Pakaian</label>
                            <input type="text" id="jenis_pakaian" name="jenis_pakaian" class="form-control">
                            <div class="invalid-feedback errorJenisPakaian"></div>
                        </div>
                        <div class="mb-3">
                            <label for="harga_perkilo" class="form-label">Harga (Perkilo)</label>
                            <input type="text" id="harga_perkilo" name="harga_perkilo" class="form-control">
                            <div class="invalid-feedback errorHargaPerkilo"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        const inputHarga = document.getElementById('harga_perkilo');

        // Menambahkan event listener untuk memformat nilai saat pengguna memasukkan data
        inputHarga.addEventListener('input', formatIDR);

        function formatIDR() {
            // Mengambil nilai input harga
            const harga = inputHarga.value;

            // Menghapus tanda baca dan karakter non-digit dari nilai harga
            const cleanedHarga = harga.replace(/\D/g, '');

            // Memastikan nilai tidak kosong
            if (cleanedHarga !== '') {
                // Mengubah nilai menjadi format IDR menggunakan fungsi rupiah
                const formattedHarga = rupiah(parseInt(cleanedHarga));

                // Menampilkan nilai yang sudah diformat
                inputHarga.value = formattedHarga;
            }
        }

        const rupiah = (number) => {
            const formatter = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            });

            return formatter.format(number).replace(/Rp\s?|(,*)/g, '');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('jenisPakaian.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis_pakaian',
                        name: 'jenis_pakaian'
                    },
                    {
                        data: 'harga_perkilo',
                        name: 'harga_perkilo'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    }
                ]
            });
        });

        $('#btnTambah').click(function() {
            $('#id').val('');
            $('#modalLabel').html("Tambah data");
            $('#modal').modal('show');
            $('#form').trigger("reset");

            $('#jenis_pakaian').removeClass('is-invalid');
            $('.errorJenisPakaian').html('');

            $('#harga_perkilo').removeClass('is-invalid');
            $('.errorHargaPerkilo').html('');
        });

        // Edit Data
        $('body').on('click', '#btnEdit', function() {
            let id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "jenis-pakaian/" + id + "/edit",
                dataType: "json",
                success: function(response) {
                    $('#modalLabel').html("Edit data");
                    $('#modal').modal('show');
                    $('#simpan').val("edit-data");

                    $('#jenis_pakaian').removeClass('is-invalid');
                    $('.errorJenisPakaian').html('');

                    $('#harga_perkilo').removeClass('is-invalid');
                    $('.errorHargaPerkilo').html('');

                    $('#id').val(response.id);
                    $('#jenis_pakaian').val(response.jenis_pakaian);
                    $('#harga_perkilo').val(response.harga_perkilo);
                }
            });
        })

        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('jenisPakaian.store') }}",
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
                        if (response.errors.jenis_pakaian) {
                            $('#jenis_pakaian').addClass('is-invalid');
                            $('.errorJenisPakaian').html(response.errors.jenis_pakaian);
                        } else {
                            $('#jenis_pakaian').removeClass('is-invalid');
                            $('.errorJenisPakaian').html('');
                        }

                        if (response.errors.harga_perkilo) {
                            $('#harga_perkilo').addClass('is-invalid');
                            $('.errorHargaPerkilo').html(response.errors.harga_perkilo);
                        } else {
                            $('#harga_perkilo').removeClass('is-invalid');
                            $('.errorHargaPerkilo').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                        })
                        $('#modal').modal('hide');
                        $('#form').trigger("reset");
                        $('#datatable').DataTable().ajax.reload()
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownError);
                }
            });
        });

        $('body').on('click', '#btnHapus', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus',
                text: "Apakah anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('jenis-pakaian/"+id+"') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.success,
                                });
                                $('#datatable').DataTable().ajax.reload()
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    })
                }
            })
        })
    </script>
@endsection
