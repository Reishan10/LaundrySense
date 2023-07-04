<?php

namespace App\Http\Controllers;

use App\Models\JenisPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisPakaianController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $jenisPakaian = JenisPakaian::orderBy('jenis_pakaian', 'asc')->get();
            return DataTables::of($jenisPakaian)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == '1') {
                        $badgeStatus = '<span class="badge bg-success">Aktif</span>';
                        return $badgeStatus;
                    } else {
                        $badgeStatus = '<span class="badge bg-danger">Tidak Aktif</span>';
                        return $badgeStatus;
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-sm btn-warning me-2" data-id="' . $data->id . '" id="btnEdit"><i class="mdi mdi-pencil me-1"></i>Edit</button>';
                    $btn = $btn . '<button type="button" class="btn btn-sm btn-danger me-2" data-id="' . $data->id . '" id="btnHapus"><i class="mdi mdi-trash-can me-1"></i>Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'status'])
                ->make(true);
        }
        return view('jenisPakaian');
    }

    public function edit($id)
    {
        $data = JenisPakaian::where('id', $id)->first();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'jenis_pakaian' => 'required',
                'harga_perkilo' => 'required',
            ],
            [
                'jenis_pakaian.required' => 'Silakan isi jenis pakaian terlebih dahulu!',
                'harga_perkilo.required' => 'Silakan isi harga terlebih dahulu!',
            ]
        );
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $jenisPakaian = JenisPakaian::updateOrCreate([
                'id' => $id
            ], [
                'jenis_pakaian' => $request->jenis_pakaian,
                'harga_perkilo' => $request->harga_perkilo,
            ]);
            return response()->json($jenisPakaian);
        }
    }

    public function destroy(Request $request)
    {
        $data = JenisPakaian::where('id', $request->id)->delete();
        return Response()->json(['data' => $data, 'success' => 'Data berhasil dihapus']);
    }
}
