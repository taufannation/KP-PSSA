<?php

namespace App\ImportsTabungan\Tabungan\Excel;

use App\Models\Tabungan;
use App\Models\KategoriTabungan;
use App\Models\JenisTransaksiTabungan;
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

        $tanggal_transaksi              = isset($row[1]) ? date('Y-m-d', strtotime(str_replace('/', '-', $row[1]))) : '';
        $kode_kategori_tabungan         = isset($row[2]) ? $row[2] : '';
        $kode_jenis_transaksi_tabungan  = isset($row[3]) ? $row[3] : '';
        $keterangan                     = isset($row[4]) ? $row[4] : '';

        $debet                          = isset($row[5]) ? $row[5] : 0;
        $kredit                         = isset($row[6]) ? $row[6] : 0;
        $saldo                          = isset($row[7]) ? $row[7] : 0;

        $debet_explode                  = explode(',', $debet);
        $kredit_explode                 = explode(',', $kredit);
        $saldo_explode                  = explode(',', $saldo);

        $debet                          = isset($debet_explode[0]) ? str_replace(array(',', '.'), '', $debet_explode[0]) : 0;
        $kredit                         = isset($kredit_explode[0]) ? str_replace(array(',', '.'), '', $kredit_explode[0]) : 0;
        $saldo                          = isset($saldo_explode[0]) ? str_replace(array(',', '.'), '', $saldo_explode[0]) : 0;

        # AMBIL ID KATEGORI TABUNGAN BERDASARKAN KODE
        $kategori_tabungan = KategoriTabungan::where('kode', $kode_kategori_tabungan)->first();
        if(!empty($kategori_tabungan)){
            $kategori_tabungan_id = $kategori_tabungan->id;
        } else {
            $kategori_tabungan_id = 0;
        }

        # AMBIL ID JENIS TRANSAKSI TABUNGAN BERDASARKAN KODE
        $jenis_transaksi_tabungan = JenisTransaksiTabungan::where('kode', $kode_jenis_transaksi_tabungan)->first();
        if(!empty($jenis_transaksi_tabungan)){
            $jenis_transaksitabungan_id = $jenis_transaksi_tabungan->id;
        } else {
            $jenis_transaksitabungan_id = 0;
        }

        Tabungan::create([
                    'tanggal_transaksi'             => $tanggal_transaksi,
                    'kategori_tabungan_id'          => $kategori_tabungan_id,
                    'jenis_transaksitabungan_id'    => $jenis_transaksitabungan_id,
                    'keterangan'                    => $keterangan,
                    'debet'                         => $debet,
                    'kredit'                        => $kredit,
                    'saldo'                         => $saldo,
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
