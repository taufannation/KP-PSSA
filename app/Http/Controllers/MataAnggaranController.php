<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\MataAnggaran;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MataAnggaranController extends Controller
{
    public function index(Request $request)
    {
        // $data = ComodityLocation::get()->first();
        if (request()->ajax()) {
            $result = MataAnggaran::orderBy('kode', 'ASC');
            return DataTables::eloquent($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.mataanggaran.modal.action', compact('data'));
                })
                ->rawColumns(['act'])->make(true);
        }
        return view('pages.mataanggaran.index');
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
            $mata_anggarans = MataAnggaran::create([
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
        $data = MataAnggaran::find($id);
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
            $mata_anggarans = MataAnggaran::find($id)->update($data);
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
        $data = MataAnggaran::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $mata_anggarans = MataAnggaran::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }
}
