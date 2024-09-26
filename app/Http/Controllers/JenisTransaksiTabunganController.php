<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\JenisTransaksiTabungan;
use App\Models\Tabungan;
use App\Models\KategoriTabungan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisTransaksiTabunganController extends Controller
{
    public function index(Request $request)
    {
        // $data = ComodityLocation::get()->first();
        if (request()->ajax()) {
            $result = JenisTransaksiTabungan::orderBy('kode', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.jenis-transaksi-tabungan.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.jenis-transaksi-tabungan.index');
    }

    public function store(Request $request)
    {
        $validate = [
            'kode'          => 'required',
            'nama'   => 'required',
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
            $jenis_transaksitabungans = JenisTransaksiTabungan::create([
                'kode'          => $request->kode,
                'nama'   => $request->nama
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
        $data = JenisTransaksiTabungan::find($id);
        return response()->json([' status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'kode'          => 'required',
            'nama'   => 'required'
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
                'kode'         => $request->kode,
                'nama'  => $request->nama
            ];
            $jenis_transaksitabungans = JenisTransaksiTabungan::find($id)->update($data);
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
        $data = JenisTransaksiTabungan::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $jenis_transaksitabungans = JenisTransaksiTabungan::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }
}
