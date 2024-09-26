<?php


namespace App\Http\Controllers;

use App\Models\TabunganBni;
use App\Models\KodeBni;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfControllertbni extends Controller
{
    public function generatePDF(Request $request)
    {
        $enable_filter      = $request->input('enable_filter');
        $start_date         = $request->input('start_date');
        $end_date           = $request->input('end_date');
        $kode_bni_id   = $request->input('kode_bni_id');

        $judul_report   = 'LAPORAN Tabungan';
        $filter_report  = '';
        $isFilter       = false;

        $query = TabunganBni::with('kode_bni')->orderBy('tanggal_transaksi', 'ASC');

        if ($enable_filter && $start_date && $end_date) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date   = date('Y-m-d', strtotime($end_date));

            $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);

            $isFilter       = true;
            $filter_report .= ' ' . strtoupper($this->stringMonthInd($start_date) . ' - ' . $this->stringMonthInd($end_date));
        }

        if (!empty($kode_bni_id)) {
            $query->where('kode_bni_id', $kode_bni_id);

            $kode_bni = KodeBni::find($kode_bni_id)->get()->first();
            if (!empty($kode_bni)) {
                $isFilter       = true;
                $filter_report .= ' BY KODE TRANSAKSI: ' . strtoupper($kode_bni->nama);
            }
        }

        if ($isFilter) {
            $judul_report .= $filter_report;
        } else {
            $judul_report .= ' KESELURUHAN';
        }

        $kode_bnis = $query->get();

        $data = [
            'kode_bnis'        => $kode_bnis,
            'judul_report'      => $judul_report,
        ];

        if ($request->ajax()) {
            return response()->json($data);
        }

        $pdf = PDF::loadView('pages.tabungan-bni.pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->download('Print Tabungan BNI - ' . date('d M Y') . '.pdf');
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
