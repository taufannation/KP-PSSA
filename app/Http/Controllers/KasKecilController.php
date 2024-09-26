<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\Models\KasKecil;
use App\Models\MataAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\ExportsKasKecil\KasKecil\Excel\Export;
use App\ImportsKasKecil\KasKecil\Excel\Import;

class KasKecilController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {

            $query = KasKecil::with('mata_anggaran')->orderBy('tanggal_transaksi', 'ASC');

            # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
            if (request()->has('enable_filter') && request()->has('start_date') && request()->has('end_date')) {
                $start_date     = date('Y-m-d', strtotime(request()->get('start_date')));
                $end_date       = date('Y-m-d', strtotime(request()->get('end_date')));

                $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);
            }

            # JIKA DIFILTER DROPDOWN MATA ANGGARAN
            if (request()->get('mata_anggaran_id')) {
                $mata_anggaran_id = request()->get('mata_anggaran_id');

                $query->where('mata_anggaran_id', '=', $mata_anggaran_id);
            }

            $result = $query->get();

            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.kaskecil.modal.action', compact('data'));
                })
                ->addColumn('kode_mata_anggaran', function ($row) {
                    if (isset($row->mata_anggaran->kode)) {
                        $result =  $row->mata_anggaran->kode;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->addColumn('nama_mata_anggaran', function ($row) {
                    if (isset($row->mata_anggaran->nama)) {
                        $result =  $row->mata_anggaran->nama;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->rawColumns(['act', 'nama_mata_anggaran'])
                ->make(true);
        }

        $mata_anggarans = MataAnggaran::orderBy('kode', 'ASC')->get();

        return view('pages.kaskecil.index', compact('mata_anggarans'));
    }

    public function store(Request $request)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'mata_anggaran_id'  => 'required',
            'nama_transaksi'    => 'required',
            'debet'             => 'required',
            'kredit'            => 'required',
            'saldo'             => 'nullable',


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
            $kas_kecils = KasKecil::create([
                'tanggal_transaksi'     => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'mata_anggaran_id'      => $request->mata_anggaran_id,
                'nama_transaksi'        => $request->nama_transaksi,
                'debet'                 => str_replace(array(',', '.'), '', $request->debet),
                'kredit'                => str_replace(array(',', '.'), '', $request->kredit),
                'saldo'                 => str_replace(array(',', '.'), '', $request->saldo),
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
        $data = KasKecil::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'mata_anggaran_id'  => 'required',
            'nama_transaksi'    => 'required',
            'debet'             => 'required',
            'kredit'            => 'required',
            'saldo'             => 'nullable',
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
                'tanggal_transaksi' => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'mata_anggaran_id'  => $request->mata_anggaran_id,
                'nama_transaksi'    => $request->nama_transaksi,
                'debet'             => str_replace(array(',', '.'), '', $request->debet),
                'kredit'            => str_replace(array(',', '.'), '', $request->kredit),
                'saldo'             => str_replace(array(',', '.'), '', $request->saldo),
            ];
            $kas_kecils = KasKecil::find($id)->update($data);
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
        $data = KasKecil::with('mata_anggaran')->find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kas_kecils = KasKecil::find($id)->delete();
            return response()->json(['status' => 'success', 'messages' => 'Data Telah Dihapus'], 201);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'messages' => $e->errorInfo], 500);
        } finally {
            DB::commit();
        }
    }

    public function export(Request $request)
    {
        $kas_kecils = KasKecil::all();
        if (count($kas_kecils) != 0) {

            $judul_report   = 'LAPORAN KAS KECIL';
            $filter_report  = '';
            $isFilter       = false;

            # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
            if (request()->has('enable_filter') && request()->has('start_date') && request()->has('end_date')) {
                $start_date     = date('Y-m-d', strtotime(request()->get('start_date')));
                $end_date       = date('Y-m-d', strtotime(request()->get('end_date')));
                $isFilter       = true;
                $filter_report .= ' ' . strtoupper($this->stringMonthInd($start_date) . ' - ' . $this->stringMonthInd($end_date));
            }

            # JIKA DIFILTER DROPDOWN MATA ANGGARAN
            if (request()->get('mata_anggaran_id')) {
                $mata_anggaran_id = request()->get('mata_anggaran_id');

                $mata_anggaran = MataAnggaran::find($mata_anggaran_id)->get()->first();
                if (!empty($mata_anggaran)) {
                    $isFilter       = true;
                    $filter_report .= ' BY MATA ANGGARAN: ' . strtoupper($mata_anggaran->nama);
                }
            }

            if ($isFilter) {
                $judul_report .= $filter_report;
            } else {
                $judul_report .= ' KESELURUHAN';
            }

            return Excel::download(new Export($request->all(), $judul_report), 'Export Data Kas Kecil - ' . date('d M Y') . '.xlsx');
        }
        toastr()->error('Tidak ada Data');
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

    private function stringMonthInd($param)
    {
        /* Output : 09 Maret 2014*/
        $date = substr($param, 8, 2);
        $month = $this->getMonthIndonesia(substr($param, 5, 2));
        $year = substr($param, 0, 4);

        return $date . ' ' . $month . ' ' . $year;
    }

    private function getMonthIndonesia($param)
    {
        switch ($param) {
            case 1:
                return "Januari";
                break;

            case 2:
                return "Februari";
                break;

            case 3:
                return "Maret";
                break;

            case 4:
                return "April";
                break;

            case 5:
                return "Mei";
                break;

            case 6:
                return "Juni";
                break;

            case 7:
                return "Juli";
                break;

            case 8:
                return "Agustus";
                break;

            case 9:
                return "September";
                break;

            case 10:
                return "Oktober";
                break;

            case 11:
                return "November";
                break;

            case 12:
                return "Desember";
                break;
        }
    }
}
