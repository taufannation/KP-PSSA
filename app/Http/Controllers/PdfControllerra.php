<?php

namespace App\Http\Controllers;

use App\Models\RealisasiAnggaran;
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade
use Illuminate\Http\Request;

class PdfControllerra extends Controller
{
    public function generatePDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $nama_bulan = \DateTime::createFromFormat('!m', $bulan)->format('F');

        $realisasi_anggarans = RealisasiAnggaran::where('bulan', $nama_bulan)->where('tahun', $tahun)->get();

        $toko = 'Lembaga Kesejahteraan Sosial Anak FAJAR HARAPAN';
        $judul_laporan = 'Laporan Realisasi Anggaran ' . $nama_bulan . ' ' . $tahun;

        $pdf = PDF::loadView('pages.realisasianggaran.pdf', compact('realisasi_anggarans', 'toko', 'judul_laporan'))->setPaper('a4');
        return $pdf->download('laporan-realisasi-anggaran.pdf'); // Provide a suitable name for your PDF file
    }
}




// <?php

// namespace App\Http\Controllers;

// use App\Models\Tabungan;
// use Barryvdh\DomPDF\Facade\Pdf;

// class PdfControllertb extends Controller
// {
//     public function generatePDF()
//     {
//         $tabungans = Tabungan::all();
//         $toko = 'PSAA FAJAR HARAPAN';
//         $pdf = PDF::loadView('pages.tabungan.pdf', compact(['tabungans', 'toko']))->setPaper('a4');
//         return $pdf->download('print-tabungan.pdf');
//     }
// }















//     public function generatePDFOne($id)
//     {
//         $comodities = Comodities::find($id);
//         $toko = 'PSAA FAJAR HARAPAN';
//         $pdf = PDF::loadView('pages.comodities.pdfone', compact(['comodities', 'toko']))->setPaper('a4');
//         return $pdf->download('print.pdf');
//     }
// }
