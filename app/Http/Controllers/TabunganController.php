<?php

namespace App\Http\Controllers;

use App\Helpers\Custom;
use App\ExportsTabungan\Tabungan\Excel\Export;
use App\Models\Tabungan;
use App\Models\KategoriTabungan;
use App\Models\JenisTransaksiTabungan;
use App\ImportsTabungan\Tabungan\Excel\Import;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TabunganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            $query = Tabungan::with(['kategori_tabungan', 'jenis_transaksi_tabungan'])->orderBy('tanggal_transaksi', 'ASC');

            # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
            if (request()->has('enable_filter') && request()->has('start_date') && request()->has('end_date')) {
                $start_date     = date('Y-m-d', strtotime(request()->get('start_date')));
                $end_date       = date('Y-m-d', strtotime(request()->get('end_date')));

                $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);
            }

            # JIKA DIFILTER DROPDOWN KODE TABUNGAN
            if (request()->get('kategori_tabungan_id')) {
                $kategori_tabungan_id = request()->get('kategori_tabungan_id');

                $query->where('kategori_tabungan_id', '=', $kategori_tabungan_id);
            }

            session()->put('kategori_tabungan_id', request()->get('kategori_tabungan_id'));

            $result = $query->get();

            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('act', function ($data) {
                    return view('pages.tabungan.modal.action', compact('data'));
                })
                ->addColumn('nama_kategori_tabungan', function ($row) {
                    if (isset($row->kategori_tabungan->nama)) {
                        $result =  $row->kategori_tabungan->nama;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->addColumn('nama_jenis_transaksi_tabungan', function ($row) {
                    if (isset($row->jenis_transaksi_tabungan->nama)) {
                        $result =  $row->jenis_transaksi_tabungan->nama;
                    } else {
                        $result = '';
                    }
                    return $result;
                })
                ->rawColumns(['act', 'nama_kategori_tabungan', 'nama_jenis_transaksi_tabungan'])
                ->make(true);
        }

        $kategori_tabungans = KategoriTabungan::orderBy('nama', 'ASC')->get();
        $jenis_transaksitabungans = JenisTransaksiTabungan::orderBy('nama', 'ASC')->get();

        return view('pages.tabungan.index', compact('kategori_tabungans', 'jenis_transaksitabungans'));
    }

    public function store(Request $request)
    {
        $validate = [
            'tanggal_transaksi'             => 'required',
            'kategori_tabungan_id'          => 'required',
            'jenis_transaksitabungan_id'    => 'required',
            'keterangan'                    => 'required',
            'debet'                         => 'required',
            'kredit'                        => 'required',
            'saldo'                         => 'nullable'
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
            $tabungans = Tabungan::create([
                'tanggal_transaksi'             => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'kategori_tabungan_id'          => $request->kategori_tabungan_id,
                'jenis_transaksitabungan_id'    => $request->jenis_transaksitabungan_id,
                'keterangan'                    => $request->keterangan,
                'debet'                         => str_replace(array(',', '.'), '', $request->debet),
                'kredit'                        => str_replace(array(',', '.'), '', $request->kredit),
                'saldo'                         => str_replace(array(',', '.'), '', $request->saldo),

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
        $data = Tabungan::find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }


    //update
    public function update(Request $request, $id)
    {
        $validate = [
            'tanggal_transaksi'             => 'required',
            'kategori_tabungan_id'          => 'required',
            'jenis_transaksitabungan_id'    => 'required',
            'keterangan'                    => 'required',
            'debet'                         => 'required',
            'kredit'                        => 'required',
            'saldo'                         => 'nullable'
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
                'tanggal_transaksi'             => date('Y-m-d', strtotime($request->tanggal_transaksi)),
                'kategori_tabungan_id'          => $request->kategori_tabungan_id,
                'jenis_transaksitabungan_id'    => $request->jenis_transaksitabungan_id,
                'keterangan'                    => $request->keterangan,
                'debet'                         => str_replace(array(',', '.'), '', $request->debet),
                'kredit'                        => str_replace(array(',', '.'), '', $request->kredit),
                'saldo'                         => str_replace(array(',', '.'), '', $request->saldo),

            ];
            $tabungans = Tabungan::find($id)->update($data);
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
        $data = Tabungan::with(['kategori_tabungan', 'jenis_transaksi_tabungan'])->find($id);
        return response()->json(['status' => 'success', 'messages' => 'Load Data', 'data' => $data], 201);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tabungans = Tabungan::find($id)->delete();
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
        $tabungans = Tabungan::all();
        if (count($tabungans) != 0) {

            $judul_report           = 'LAPORAN TABUNGAN';
            $filter_report          = '';
            $isFilter               = false;

            # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
            if (request()->has('enable_filter') && request()->has('start_date') && request()->has('end_date')) {
                $start_date     = date('Y-m-d', strtotime(request()->get('start_date')));
                $end_date       = date('Y-m-d', strtotime(request()->get('end_date')));
                $isFilter       = true;
                $filter_report .= ' ' . strtoupper($this->stringMonthInd($start_date) . ' - ' . $this->stringMonthInd($end_date));
            }

            # JIKA DIFILTER DROPDOWN KODE TABUNGAN
            if (request()->get('kategori_tabungan_id')) {
                $kategori_tabungan_id = request()->get('kategori_tabungan_id');

                $kategori_tabungan = KategoriTabungan::find($kategori_tabungan_id)->get()->first();
                if (!empty($kategori_tabungan)) {
                    $isFilter       = true;
                    $filter_report .= ' BY TABUNGAN: ' . strtoupper($kategori_tabungan->nama);
                }
            }

            if ($isFilter) {
                $judul_report .= $filter_report;
            } else {
                $judul_report .= ' KESELURUHAN';
            }

            return Excel::download(new Export($request->all(), $judul_report), 'Export Data Tabungan - ' . date('d M Y') . '.xlsx');
        }
        toastr()->error('Tidak ada Data');
        return redirect()->back()->withInput();
    }

    public function import()
    {
        try {
            Excel::import(new Import, request()->file('file'));
            toastr()->success('Import Data Berhasil');
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
