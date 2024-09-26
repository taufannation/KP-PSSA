<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfControllerds extends Controller
{
    public function generatePDF()
    {
        $data_siswas = DataSiswa::all();
        $toko = 'PSAA FAJAR HARAPAN';
        $pdf = PDF::loadView('pages.data_siswa.pdf', compact(['data_siswas', 'toko']))->setPaper('a4', 'landscape');
        return $pdf->download('print-data-siswa.pdf');
    }

    public function generatePDFOne($id)
    {
        $data_siswas = DataSiswa::find($id);
        $toko = 'PSAA FAJAR HARAPAN';
        $pdf = PDF::loadView('pages.data_siswa.pdfone', compact(['data_siswas', 'toko']))->setPaper('a4');
        return $pdf->download('print-data-asset.pdf');
    }
}
