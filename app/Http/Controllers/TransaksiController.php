<?php

namespace App\Http\Controllers;

use App\Models\JenisPakaian;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $transaksi = Transaksi::with('user')->orderBy('invoice', 'asc')->get();
            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->addColumn('nama_pelanggan', function ($data) {
                    $name = $data->user->name;
                    return $name;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == '1') {
                        $badgeStatus = '<span class="badge bg-success">Belum Selesai</span>';
                        return $badgeStatus;
                    } else {
                        $badgeStatus = '<span class="badge bg-danger">Selesai</span>';
                        return $badgeStatus;
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a href="' . route('transaksi.print', $data->id) . '" class="btn btn-sm btn-info me-1" target="_blank"><i class="mdi mdi-printer"></i></a>';
                    if ($data->status == '1') {
                        $btn = $btn . '<button type="button" class="btn btn-sm btn-warning me-1" data-id="' . $data->id . '" id="btnUpdate"><i class="mdi mdi-check"></i></button>';
                    }
                    $btn = $btn . '<button type="button" class="btn btn-sm btn-danger me-1" data-id="' . $data->id . '" id="btnHapus"><i class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'status'])
                ->make(true);
        }
        return view('transaksi.index');
    }

    public function create()
    {
        $user = User::orderBy('name', 'asc')->get();
        $jenis = JenisPakaian::orderBy('jenis_pakaian', 'asc')->get();
        return view('transaksi.create', compact(['user', 'jenis']));
    }

    public function getHarga(Request $request)
    {
        $jenisPakaianId = $request->jenis_pakaian_id;
        $harga = JenisPakaian::find($jenisPakaianId)->harga_perkilo;

        return response()->json(['harga' => $harga]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'pelanggan' => 'required|string',
                'berat' => 'required|string',
                'jenis_pakaian' => 'required|string',
                'jumlah' => 'required|string',
                'tgl_mulai' => 'required|string',
                'tgl_selesai' => 'required|string',
            ],
            [
                'pelanggan.required' => 'Silakan isi pelanggan terlebih dahulu!',
                'berat.required' => 'Silakan isi berat terlebih dahulu!',
                'jenis_pakaian.required' => 'Silakan isi jenis pakaian terlebih dahulu!',
                'jumlah.required' => 'Silakan isi jumlah terlebih dahulu!',
                'tgl_mulai.required' => 'Silakan isi tanggal mulai terlebih dahulu!',
                'tgl_selesai.required' => 'Silakan isi tanggal selesai terlebih dahulu!',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $transaksi = new Transaksi();
            $transaksi->invoice = "";

            // Simpan nomor invoice bersama atribut lainnya
            $transaksi->id_jenis_pakaian = $request->jenis_pakaian;
            $transaksi->id_user = $request->pelanggan;
            $transaksi->berat = $request->berat . " Kg";
            $transaksi->harga = $request->jumlah;
            $transaksi->tgl_mulai = $request->tgl_mulai;
            $transaksi->tgl_selesai = $request->tgl_selesai;
            $transaksi->status = "1";

            // Generate nomor invoice
            $currentDate = Carbon::now();
            $transaksiCount = Transaksi::whereDate('created_at', '=', $currentDate->format('Y-m-d'))->count();
            $nomorUrutan = str_pad($transaksiCount + 1, 4, '0', STR_PAD_LEFT);
            $nomorInvoice = 'INV' . $currentDate->format('ymd') . $nomorUrutan;

            // Tambahkan nomor invoice ke objek transaksi
            $transaksi->invoice = $nomorInvoice;

            // Simpan transaksi ke database
            $transaksi->save();
            return response()->json(['success' => 'Data berhasil ditambahkan']);
        }
    }

    public function update(Request $request)
    {
        $transaksi = Transaksi::find($request->id);
        $transaksi->status = '2';
        $transaksi->save();
        return Response()->json(['transaksi' => $transaksi, 'success' => 'Data berhasil diupdate']);
    }

    public function destroy(Request $request)
    {
        $data = Transaksi::where('id', $request->id)->delete();
        return Response()->json(['data' => $data, 'success' => 'Data berhasil dihapus']);
    }

    public function print($id)
    {
        // Mengambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with('user', 'jenis_pakaian')->findOrFail($id);
        return view('transaksi.print', compact('transaksi'));
    }
}
