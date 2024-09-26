<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\ExportsKasKecil\KasKecil\Excel\Export;
use App\Models\TabunganBri;
use App\Models\KodeBri;
use App\ImportsKasKecil\KasKecil\Excel\Import;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TabunganBriController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {

            $query = TabunganBri::with('kode_bris')->orderBy('tanggal_transaksi', 'ASC');

            # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
            if (request()->has('enable_filter') && request()->has('start_date') && request()->has('end_date')) {
                $start_date     = date('Y-m-d', strtotime(request()->get('start_date')));
                $end_date       = date('Y-m-d', strtotime(request()->get('end_date')));

                $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);
            }

            # JIKA DIFILTER DROPDOWN KODE BRI
            if (request()->get('kode_bri_id')) {
                $kode_bri_id = request()->get('kode_bri_id');

                $query->where('kode_bri_id', '=', $kode_bri_id);
            }

            $result = $query->get();

            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.tabunganbri.modal.action', compact('data'));
                })
                ->addColumn('kode_kode_bris', function ($row) {
                    if (isset($row->kode_bris->kode)) {
                        $result =  $row->kode_bris->kode;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->addColumn('nama_kode_bris', function ($row) {
                    if (isset($row->kode_bris->nama)) {
                        $result =  $row->kode_bris->nama;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->rawColumns(['act', 'nama_kode_bris'])
                ->make(true);
        }

        $kode_bris = TabunganBri::orderBy('kode', 'ASC')->get();

        return view('pages.tabunganbri.index', compact('kode_bris'));
    }

    public function store(Request $request)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'kode_bri_id'  => 'required',
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
            $tabungan_bris = TabunganBri::create([
                'tanggal_transaksi'     => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'kode_bri_id'      => $request->kode_bri_id,
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
        $data = TabunganBri::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $validate = [
            'tanggal_transaksi' => 'required',
            'kode_bri_id'  => 'required',
            'nama_transaksi'    => 'required',
            'debet'             => 'required',
            'kredit'            => 'required',
            'saldo'             => 'required',
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
                'kode_bri_id'  => $request->kode_bri_id,
                'nama_transaksi'    => $request->nama_transaksi,
                'debet'             => str_replace(array(',', '.'), '', $request->debet),
                'kredit'            => str_replace(array(',', '.'), '', $request->kredit),
                'saldo'             => str_replace(array(',', '.'), '', $request->saldo),
            ];
            $kas_kecils = TabunganBri::find($id)->update($data);
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
        $data = TabunganBri::with('kode_bris')->find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tabungan_bris = TabunganBri::find($id)->delete();
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
        $kas_kecils = TabunganBri::all();
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

            # JIKA DIFILTER DROPDOWN KODE
            if (request()->get('kode_bri_id')) {
                $kode_bri_id = request()->get('kode_bri_id');

                $kode_bri = KodeBri::find($kode_bri_id)->get()->first();
                if (!empty($kode_bri)) {
                    $isFilter       = true;
                    $filter_report .= ' BY KODE : ' . strtoupper($kode_bri->nama);
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
