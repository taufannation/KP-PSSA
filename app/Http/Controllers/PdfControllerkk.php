<?php


namespace App\Http\Controllers;

use App\Models\KasKecil;
use App\Models\MataAnggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfControllerkk extends Controller
{
    public function generatePDF(Request $request)
    {
        $enable_filter      = $request->input('enable_filter');
        $start_date         = $request->input('start_date');
        $end_date           = $request->input('end_date');
        $mata_anggaran_id   = $request->input('mata_anggaran_id');

        $judul_report   = 'LAPORAN KAS KECIL';
        $filter_report  = '';
        $isFilter       = false;

        $query = KasKecil::with('mata_anggaran')->orderBy('tanggal_transaksi', 'ASC');

        if ($enable_filter && $start_date && $end_date) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date   = date('Y-m-d', strtotime($end_date));

            $query->whereBetween('tanggal_transaksi', [$start_date, $end_date]);

            $isFilter       = true;
            $filter_report .= ' ' . strtoupper($this->stringMonthInd($start_date) . ' - ' . $this->stringMonthInd($end_date));
        }

        if (!empty($mata_anggaran_id)) {
            $query->where('mata_anggaran_id', $mata_anggaran_id);

            $mata_anggaran = MataAnggaran::find($mata_anggaran_id);
            if (!empty($mata_anggaran)) {
                $isFilter       = true;
                $filter_report .= ' MATA ANGGARAN : ' . strtoupper($mata_anggaran->nama);
            }
        }

        if ($isFilter) {
            $judul_report .= $filter_report;
        } else {
            $judul_report .= ' KESELURUHAN';
        }

        $kas_kecils = $query->get();

        $data = [
            'kas_kecils'        => $kas_kecils,
            'judul_report'      => $judul_report,
        ];

        if ($request->ajax()) {
            return response()->json($data);
        }

        $pdf = PDF::loadView('pages.kaskecil.pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->download('Print Data Kas Kecil - ' . date('d M Y') . '.pdf');
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
