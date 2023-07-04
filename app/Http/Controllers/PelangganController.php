<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $pelanggan = User::where('level', '1')->orderBy('name', 'asc')->get();
            return DataTables::of($pelanggan)
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
        return view('pelanggan');
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'no_telepon' => 'required|unique:users,no_telepon,' . $id . '|min:11|max:15',
                'alamat' => 'required',
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
                'alamat.required' => 'Silakan isi alamat terlebih dahulu!',
            ]
        );
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $pelanggan = User::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->no_telepon),
                'level' => 1,
                'status' => 1,
            ]);
            return response()->json($pelanggan);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        return Response()->json(['user' => $user, 'success' => 'Data berhasil dihapus']);
    }
}
