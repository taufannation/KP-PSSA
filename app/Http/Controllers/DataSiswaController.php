<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\DataSiswa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class DataSiswaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $result = DataSiswa::orderBy('id', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.data_siswa.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.data_siswa.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'nama'                 => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'jenis_kelamin'        => 'required',
            'pendidikan_terakhir'  => 'required',
            'nama_ayah'            => 'required',
            'nama_ibu'             => 'required',
            'pekerjaan_orangtua'   => 'required',
            'alamat'               => 'required',
            'tanggal_masuk'        => 'required',
            'tanggal_keluar'       => 'nullable',
            'status'               => 'nullable',
            'keterangan'           => 'nullable',
            'foto'                 => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan validasi ekstensi dan tipe file



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

            $foto_file = $request->file('foto');
            $foto_ekstensi = $foto_file->extension();
            $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
            $foto_file->move(public_path('fotosiswa'), $foto_nama);

            $tempat_tanggal_lahir = $request->tempat_lahir . ', ' . date('d F Y', strtotime($request->tanggal_lahir));
            $dataSiswa = DataSiswa::create([
                'nama'                   => $request->nama,
                'tanggal_lahir'   => date('Y-m-d', strtotime($request->tanggal_lahir)),
                'jenis_kelamin'          => $request->jenis_kelamin,
                'tempat_lahir'    => $request->tempat_lahir,
                'pendidikan_terakhir'    => $request->pendidikan_terakhir,
                'nama_ayah'              => $request->nama_ayah,
                'nama_ibu'               => $request->nama_ibu,
                'pekerjaan_orangtua'     => $request->pekerjaan_orangtua,
                'alamat'                 => $request->alamat,
                'tanggal_masuk'          => date('Y-m-d', strtotime($request->tanggal_masuk)),
                'tanggal_keluar'         => date('Y-m-d', strtotime($request->tanggal_keluar)),
                'status'                 => $request->status,
                'keterangan'            => $request->keterangan,
                'foto'              => $foto_nama,
                'tempat_tanggal_lahir' => $tempat_tanggal_lahir
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
        $data = DataSiswa::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'nama'                 => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin'        => 'required',
            'pendidikan_terakhir'  => 'required',
            'nama_ayah'            => 'required',
            'nama_ibu'             => 'required',
            'pekerjaan_orangtua'   => 'required',
            'alamat'               => 'required',
            'tanggal_masuk'        => 'required',
            'tanggal_keluar'       => 'nullable',
            'status'               => 'nullable',
            'keterangan'           => 'nullable',
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
                'nama'                   => $request->nama,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'jenis_kelamin'          => $request->jenis_kelamin,
                'pendidikan_terakhir'    => $request->pendidikan_terakhir,
                'nama_ayah'              => $request->nama_ayah,
                'nama_ibu'               => $request->nama_ibu,
                'pekerjaan_orangtua'     => $request->pekerjaan_orangtua,
                'alamat'                 => $request->alamat,
                'tanggal_masuk'          => $request->tanggal_masuk,
                'tanggal_keluar'         => $request->tanggal_keluar,
                'status'                 => $request->status,
                'keterangan'            => $request->keterangan
            ];

            // Check if a new file is uploaded
            if ($request->hasFile('foto')) {
                $foto_file = $request->file('foto');
                $foto_ekstensi = $foto_file->extension();
                $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
                $foto_file->move(public_path('fotosiswa'), $foto_nama);

                // Update the 'foto' field with the new file name
                $data['foto'] = $foto_nama;
            }

            $dataSiswa = DataSiswa::find($id)->update($data);
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
        $data = DataSiswa::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Ambil data siswa berdasarkan ID
            $dataSiswa = DataSiswa::find($id);

            // Hapus foto dari sistem file
            File::delete(public_path('fotosiswa') . '/' . $dataSiswa->foto);

            // Hapus data siswa dari database
            $dataSiswa->delete();

            DB::commit();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        }
    }
}
