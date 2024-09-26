<?php

namespace App\Http\Controllers;

use App\Exports\Comodities\Excel\Export;
use App\Helpers\Custom;
use App\Imports\Comodities\Excel\Import;
use App\Models\Comodities;
use App\Models\ComodityLocation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ComodityController extends Controller
{
    public function index()
    {
        // $comodities = Comodities::latest()->get();
        $comodity_locationss = ComodityLocation::orderBy('name', 'ASC')->get();
        if (request()->ajax()) {
            $result = Comodities::with('comodity_locations')->orderBy('name', 'ASC');
            return DataTables::of($result)
                ->addIndexColumn()
                ->editColumn('condition', function ($data) {
                    return view('pages.comodities.modal.condition', compact('data'));
                })
                ->addColumn('act', function ($data) {
                    return view('pages.comodities.modal.action', compact('data'));
                })
                ->rawColumns(['act', 'condition'])->make(true);
        }
        return view('pages.comodities.index', compact('comodity_locationss'));
    }

    public function store(Request $request)
    {
        $validate = [
            'item_code'             => 'required',
            'name'                  => 'required',
            'brand'                 => 'nullable',
            'date_of_purchase'      => 'required',
            'material'              => 'nullable',
            'comodity_locations_id' => 'required',
            'condition'             => 'required',
            'quantity'              => 'required',
            'price'                 => 'nullable',
            'note'                  => 'nullable',
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
            $comodities = Comodities::create([
                'item_code'             => $request->item_code,
                'name'                  => $request->name,
                'brand'                 => $request->brand,
                'date_of_purchase'      => date_format(date_create($request->date_of_purchase), 'd-m-Y'),
                'material'              => $request->material,
                'comodity_locations_id' => $request->comodity_locations_id,
                'condition'             => $request->condition,
                'quantity'              => $request->quantity,
                'price'                 => $request->price,
                'note'                  => $request->note
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
        $comodities = Comodities::findOrFail($id);
        // $comodities = Comodities::with('school_operational','comodity_locations')->findOrFail($id);
        $data = [
            'item_code'             => $comodities->item_code,
            'brand'                 => $comodities->brand,
            'quantity'              => $comodities->quantity,
            'price'                 => $comodities->price,
            'condition'             => $comodities->condition,
            'material'              => $comodities->material,
            'name'                  => $comodities->name,
            'date_of_purchase'      => $comodities->date_of_purchase,
            'comodity_locations_id' => $comodities->comodity_locations_id,
            'note'                  => $comodities->note
        ];
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'item_code'             => 'required',
            'name'                  => 'required',
            'brand'                 => 'nullable',
            'date_of_purchase'      => 'required',
            'material'              => 'nullable',
            'comodity_locations_id' => 'required',
            'condition'             => 'required',
            'quantity'              => 'required',
            'price'                 => 'nullable',
            'note'                  => 'nullable',
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
                'item_code'             => $request->item_code,
                'name'                  => $request->name,
                'brand'                 => $request->brand,
                'date_of_purchase'      => $request->date_of_purchase,
                'material'              => $request->material,
                'comodity_locations_id' => $request->comodity_locations_id,
                'condition'             => $request->condition,
                'quantity'              => $request->quantity,
                'price'                 => $request->price,
                'note'                  => $request->note
            ];
            $comodities = Comodities::find($id)->update($data);
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
        $comodities = Comodities::with('comodity_locations')->orderBy('name', 'ASC')->get()->find($id);
        $data = [
            'item_code'             => $comodities->item_code,
            'brand'                 => $comodities->brand,
            'quantity'              => $comodities->quantity,
            'price'                 => $comodities->price,
            'condition'             => $comodities->condition,
            'material'              => $comodities->material,
            'name'                  => $comodities->name,
            'date_of_purchase'      => $comodities->date_of_purchase,
            'comodity_locations_id' => $comodities->comodity_locations->name,
            'note'                  => $comodities->note
        ];
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 200);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $comodities = Comodities::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function export()
    {
        $comodities = Comodities::all();
        if (count($comodities) != 0) {
            return Excel::download(new Export, 'Daftar-Asset-' . date('d-m-Y') . '.xlsx');
        }
        toastr()->error('Tidak ada Asset');
        return redirect()->back()->withInput();
    }

    public function import()
    {
        try {
            Excel::import(new Import, request()->file('file'));
            toastr()->success('Import Barang Berhasil');
            return redirect()->back();
        } catch (QueryException $e) {
            toastr()->error('Gagal, Pastikan Import Data anda sesuai');
            return redirect()->back();
        }
    }
}
