<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->tgl_mulai)) {
                $transaksi = Transaksi::with('user')->whereBetween('tgl_mulai', array($request->tgl_mulai, $request->tgl_selesai))->orderBy('invoice', 'asc')->get();
            } else {
                $transaksi = Transaksi::with('user')->orderBy('invoice', 'asc')->get();
            }
            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->addColumn('nama', function ($data) {
                    $name = $data->user->name;
                    return $name;
                })
                ->make(true);
        }
        return view('laporan.index');
    }
}
