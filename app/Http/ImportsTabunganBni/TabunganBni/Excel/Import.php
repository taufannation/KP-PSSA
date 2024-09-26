<?php

namespace App\ImportsTabunganBni\TabunganBni\Excel;

use App\Models\TabunganBni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Import implements ToModel, WithStartRow, WithChunkReading, WithBatchInserts
{
    use Importable;
    private $kas_kecils;

    public function __construct()
    {
    }

    public function model(array $row)
    {
        # KOLOM B
        if (isset($row[1])) {
            $tanggal_transaksi = $row[1];
            $tanggal_transaksi = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_transaksi);
        } else {
            $tanggal_transaksi = date('Y-m-d');
        }

        # KOLOM C
        if (isset($row[2])) {
            $mata_anggaran_id = $row[2];
        } else {
            $mata_anggaran_id = '';
        }

        # KOLOM D
        if (isset($row[3])) {
            $nama_transaksi = $row[3];
        } else {
            $nama_transaksi = '';
        }

        # KOLOM E
        if (isset($row[4])) {
            $debet = $row[4];
            $debet = str_replace(array(',', '.'), '', $debet);
        } else {
            $debet = '';
        }

        # KOLOM F
        if (isset($row[5])) {
            $kredit = $row[5];
            $kredit = str_replace(array(',', '.'), '', $kredit);
        } else {
            $kredit = '';
        }

        # KOLOM G
        if (isset($row[6])) {
            $saldo = $row[6];
            $saldo = str_replace(array(',', '.'), '', $saldo);
        } else {
            $saldo = '';
        }

        return new TabunganBni([
            'tanggal_transaksi'     => $tanggal_transaksi,
            'mata_anggaran_id'      => $mata_anggaran_id,
            'nama_transaksi'        => $nama_transaksi,
            'debet'                 => $debet,
            'kredit'                => $kredit,
            'saldo'                 => $saldo,
        ]);
    }

    public function startRow(): int
    {
        return 2;
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
