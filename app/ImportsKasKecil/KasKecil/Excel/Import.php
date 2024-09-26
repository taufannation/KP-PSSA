<?php

namespace App\ImportsKasKecil\KasKecil\Excel;

use App\Models\KasKecil;
use App\Models\MataAnggaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Import implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
{
    use Importable;

    public function __construct()
    {
    }

    public function model(array $row)
    {
        /*
        $tanggal_transaksi = isset($row[1])
            ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])
            : date('Y-m-d');
        */

        $tanggal_transaksi  = isset($row[1]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[1]))) : '';
        $kode_mata_anggaran = isset($row[2]) ? $row[2] : 0;
        $nama_transaksi     = isset($row[3]) ? $row[3] : '';

        $debet              = isset($row[4]) ? $row[4] : 0;
        $kredit             = isset($row[5]) ? $row[5] : 0;
        $saldo              = isset($row[6]) ? $row[6] : 0;

        $debet_explode      = explode(',', $debet);
        $kredit_explode     = explode(',', $kredit);
        $saldo_explode      = explode(',', $saldo);

        $debet              = isset($debet_explode[0]) ? str_replace(array(',', '.'), '', $debet_explode[0]) : 0;
        $kredit             = isset($kredit_explode[0]) ? str_replace(array(',', '.'), '', $kredit_explode[0]) : 0;
        $saldo              = isset($saldo_explode[0]) ? str_replace(array(',', '.'), '', $saldo_explode[0]) : 0;

        # AMBIL ID MATA ANGGARAN BERDASARKAN KODE
        $mata_anggaran      = MataAnggaran::where('kode', $kode_mata_anggaran)->first();
        if (!empty($mata_anggaran)) {
            $mata_anggaran_id = $mata_anggaran->id;
        } else {
            $mata_anggaran_id = 0;
        }

        KasKecil::create([
            'tanggal_transaksi' => $tanggal_transaksi,
            'mata_anggaran_id'  => $mata_anggaran_id,
            'nama_transaksi'    => $nama_transaksi,
            'debet'             => $debet,
            'kredit'            => $kredit,
            'saldo'             => $saldo,
        ]);
    }

    public function startRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
