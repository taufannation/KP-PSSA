<?php

namespace App\ExportsTabungan\Tabungan\Excel;

use App\Models\RealisasiAnggaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;


class Export implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tabungans = RealisasiAnggaran
            ::all();
        return collect([
            $this->customProcessDataTabunganToExcel($tabungans)
        ]);
    }
    public function headings(): array
    {
        return [
            'Tanggal Transaksi',
            'No Transaksi',
            'Keterangan',
            'Debet',
            'Kredit',
            'Saldo'


        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->setAllBorders('thin')->egtDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }
        ];
    }
    public function customProcessDataTabunganToExcel($model)
    {
        foreach ($model as $key => $tabungans) {
            $data[$key]['tanggal_transaksi'] = $tabungans->tanggal_transaksi;
            $data[$key]['no_transaksi'] = $tabungans->no_transaksi;
            $data[$key]['keterangan'] = $tabungans->keterangan;
            $data[$key]['debet'] = $tabungans->debet;
            $data[$key]['kredit'] = $tabungans->kredit;
            $data[$key]['saldo'] = $tabungans->saldo;
        }

        return $data;
    }
}
