@extends('layouts.main')
@section('title', 'Pelanggan')
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No Telepon</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
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

    <!-- Pelanggan modal -->
    <div id="pelangganModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pelangganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="pelangganModalLabel"></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" name="name" class="form-control">
                            <div class="invalid-feedback errorName"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                            <div class="invalid-feedback errorEmail"></div>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="number" id="no_telepon" name="no_telepon" class="form-control">
                            <div class="invalid-feedback errorNoTelepon"></div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                            <div class="invalid-feedback errorAlamat"></div>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#datatable').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ route('pelanggan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_telepon',
                        name: 'no_telepon'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            $('#pelangganModalLabel').html("Tambah pelanggan");
            $('#pelangganModal').modal('show');
            $('#form').trigger("reset");

            $('#name').removeClass('is-invalid');
            $('.errorName').html('');

            $('#email').removeClass('is-invalid');
            $('.errorEmail').html('');

            $('#no_telepon').removeClass('is-invalid');
            $('.errorNoTelepon').html('');

            $('#alamat').removeClass('is-invalid');
            $('.errorAlamat').html('');
        });

        // Edit Data
        $('body').on('click', '#btnEdit', function() {
            let id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "pelanggan/" + id + "/edit",
                dataType: "json",
                success: function(response) {
                    $('#pelangganModalLabel').html("Edit pelanggan");
                    $('#pelangganModal').modal('show');
                    $('#simpan').val("edit-pelanggan");

                    $('#name').removeClass('is-invalid');
                    $('.errorName').html('');

                    $('#email').removeClass('is-invalid');
                    $('.errorEmail').html('');

                    $('#no_telepon').removeClass('is-invalid');
                    $('.errorNoTelepon').html('');

                    $('#alamat').removeClass('is-invalid');
                    $('.errorAlamat').html('');

                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#no_telepon').val(response.no_telepon);
                    $('#alamat').val(response.alamat);
                }
            });
        })

        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('pelanggan.store') }}",
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
                        if (response.errors.name) {
                            $('#name').addClass('is-invalid');
                            $('.errorName').html(response.errors.name);
                        } else {
                            $('#name').removeClass('is-invalid');
                            $('.errorName').html('');
                        }

                        if (response.errors.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.errors.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }

                        if (response.errors.no_telepon) {
                            $('#no_telepon').addClass('is-invalid');
                            $('.errorNoTelepon').html(response.errors.no_telepon);
                        } else {
                            $('#no_telepon').removeClass('is-invalid');
                            $('.errorNoTelepon').html('');
                        }

                        if (response.errors.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.errorAlamat').html(response.errors.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                        })
                        $('#pelangganModal').modal('hide');
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
                        url: "{{ url('pelanggan/"+id+"') }}",
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
