<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\DataPengajar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class DataPengajarController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $result = DataPengajar::orderBy('nama', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.data_pengajar.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.data_pengajar.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'no_ktp'        => 'nullable',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'usia'          => 'required',
            'alamat'        => 'nullable',
            'jabatan'       => 'required',
            'foto'                 => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan validasi ekstensi dan tipe file
        ];
        $validation = Validator::make($request->all(), $validate, Custom::messages());
        if ($validation->fails()) {
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        $foto_file = $request->file('foto');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
        $foto_file->move(public_path('fotopengajar'), $foto_nama);


        DB::beginTransaction();
        try {
            $dataPengajar = DataPengajar::create([
                'no_ktp'        => $request->no_ktp,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia'          => $request->usia,
                'alamat'        => $request->alamat,
                'jabatan'        => $request->jabatan,
                'foto'              => $foto_nama,
            ]);

            return response()->json(['status' => 'success', 'messages' => 'Data Success Ditambahkan'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function edit($id)
    {
        $data = DataPengajar::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'no_ktp'        => 'nullable',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            'usia'          => 'required',
            'alamat'        => 'nullable',
            'jabatan'       => 'required',
            'foto'                 => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // Foto is optional, with allowed mime types and maximum size of 2MB

        ];

        $validation = Validator::make($request->all(), $validate, Custom::messages());
        if ($validation->fails()) {
            return response()->json([
                'status'    => 'warning',
                'messages'  => $validation->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'no_ktp'        => $request->no_ktp,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia'          => $request->usia,
                'alamat'        => $request->alamat,
                'jabatan'        => $request->jabatan
            ];
            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_ekstensi = $foto_file->extension();
                $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
                $foto_file->move(public_path('fotopengajar'), $foto_nama);

                // Update the 'foto' field with the new file name
                $data['foto'] = $foto_nama;
            }

            $dataPengajar = DataPengajar::find($id)->update($data);
            return response()->json(['status' => 'success', 'messages' => 'Data Berhasil Di Update'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function show($id)
    {
        $data = DataPengajar::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $dataPengajar = DataPengajar::find($id);

            // Hapus foto dari sistem file
            File::delete(public_path('fotopengajar') . '/' . $dataPengajar->foto);

            // Hapus data siswa dari database
            $dataPengajar->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }
    }
}
