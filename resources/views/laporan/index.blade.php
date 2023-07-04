@extends('layouts.main')
@section('title', 'Laporan')
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
                    <div class="card-body">
                        <div class="tab-content">
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
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            id="refresh">Refresh</button>
                                        <button type="button" class="btn btn-primary btn-sm" id="filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="d-md-flex justify-content-between">
                                <div class="d-flex align-items-center mb-3">
                                    <button class="btn btn-secondary btn-sm ms-1" id="print">
                                        <i class="mdi mdi-printer"></i> Print
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <table id="datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Berat</th>
                                            <th>Total</th>
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

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            load_data();

            function load_data(tgl_mulai = '', tgl_selesai = '') {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('laporan.index') }}',
                        data: {
                            tgl_mulai: tgl_mulai,
                            tgl_selesai: tgl_selesai
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'invoice',
                            name: 'invoice'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'tgl_mulai',
                            name: 'tgl_mulai'
                        },
                        {
                            data: 'berat',
                            name: 'berat'
                        },
                        {
                            data: 'harga',
                            name: 'harga'
                        }
                    ]
                });
            }

            $('#filter').click(function() {
                var tgl_mulai = $('#tgl_mulai').val();
                var tgl_selesai = $('#tgl_selesai').val();

                if (tgl_mulai != '' && tgl_selesai != '') {
                    $('#datatable').DataTable().destroy();
                    load_data(tgl_mulai, tgl_selesai);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silakan isi data terlebih dahulu!',
                    })
                }

            });

            $('#refresh').click(function() {
                $('#tgl_mulai').val('');
                $('#tgl_selesai').val('');
                $('#datatable').DataTable().destroy();
                load_data();
            });


            $('#print').click(function() {
                var table = $('#datatable').DataTable();
                var data = table.data().toArray();

                var printContent =
                    '<table class="table"><thead><tr><th>No</th><th>Invoice</th><th>Nama</th><th>Tanggal</th><th>Berat</th><th>Total</th></tr></thead><tbody>';

                $.each(data, function(index, value) {
                    printContent += '<tr><td>' + (index + 1) + '</td><td>' + value.invoice +
                        '</td><td>' + value.nama +
                        '</td><td>' + value.tgl_mulai + '</td><td>' + value.berat +
                        '</td><td>' + value.harga + '</td></tr>';
                });

                printContent += '</tbody></table>';

                var printWindow = window.open('', '', 'height=500,width=800');
                printWindow.document.write('<html><head><title>Print Laporan</title>');
                printWindow.document.write(
                    '<style>body{font-family: Arial, sans-serif;font-size: 14px;}table {width: 100%;border-collapse: collapse;}td,th {padding: 5px;border: 1px solid #ddd;}th {background-color: #f2f2f2;text-align: left;}h2 {font-size: 18px;margin-top: 0;}.text-bold {font-weight: bold;}.text-center {text-align: center;}.text-right {text-align: right;}.mb-10 {margin-bottom: 10px;}</style>'
                );
                printWindow.document.write('</head><body>');
                printWindow.document.write(printContent);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            });

        });
    </script>
@endsection
