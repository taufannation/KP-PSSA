<?php

namespace App\ExportsTabunganBni\TabunganBni\Excel;

use App\Models\TabunganBni;
use App\Models\KodeBni;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Maatwebsite\Excel\Writer;
use Maatwebsite\Excel\Sheet;

class Export implements FromCollection, WithHeadings, WithColumnWidths, WithEvents, ShouldAutoSize
{
    protected $filter_data, $row_number, $row_no, $judul_report;

    public function __construct($filter_data = array(), $judul_report = '')
    {
        $this->filter_data  = $filter_data;
        $this->row_number   = 2;
        $this->row_no       = 1;
        $this->judul_report = $judul_report;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = TabunganBni::query();

        # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
        if (!empty($this->filter_data['enable_filter'])) {
            $query->whereBetween('tanggal_transaksi', [
                date('Y-m-d', strtotime($this->filter_data['start_date'])),
                date('Y-m-d', strtotime($this->filter_data['end_date']))
            ]);
        }

        # JIKA DIFILTER DROPDOWN MATA ANGGARAN
        if (!empty($this->filter_data['mata_anggaran_id'])) {
            $query->where('mata_anggaran_id', $this->filter_data['mata_anggaran_id']);
        }

        $query->with('mata_anggaran');

        $query->orderBy('tanggal_transaksi', 'asc');

        $kas_kecils = $query->get();

        return collect([
            $this->customProcessDataKasKecilToExcel($kas_kecils)
        ]);
    }
    public function registerEvents(): array
    {
        Writer::macro('setCreator', function (Writer $writer) {
            $writer->getDelegate()->getProperties()->setCreator("Report");
        });

        Writer::macro('setDefaultStyle', function (Writer $writer) {
            $writer->getDefaultStyle()->getFont()->setSize(11);
            $writer->getDefaultStyle()
                ->getNumberFormat()
                ->setFormatCode(
                    \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT
                );
        });

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
        });

        return [
            AfterSheet::class => function (AfterSheet $event) {
                # HEADING
                $event->sheet->styleCells(
                    'A1:G1',
                    [
                        'font' => [
                            'bold' => true,
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                    ]
                );

                # JUDUL REPORT
                $event->sheet->mergeCells('A1:G1');

                $baris_awal = $this->row_number++;
                $baris_akhir = $baris_awal;

                # HEADER TABLE
                $event->sheet->styleCells(
                    'A' . $baris_awal . ':G' . $baris_akhir,
                    [
                        'font' => [
                            'bold' => true,
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => '3abaf4',
                            ],
                            'endColor' => [
                                'rgb' => 'ffffff',
                            ],
                        ],
                    ]
                );

                $baris_awal     = $baris_akhir + 1;
                $baris_akhir    = $event->sheet->getHighestRow();

                # BODY TABLE - CENTER ALIGN
                $event->sheet->styleCells(
                    'A' . $baris_awal . ':C' . $baris_akhir,
                    [
                        'font' => [
                            'bold' => false,
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'D' . $baris_awal . ':D' . $baris_akhir,
                    [
                        'font' => [
                            'bold' => false,
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'E' . $baris_awal . ':G' . $baris_akhir,
                    [
                        'font' => [
                            'bold' => false,
                            'size' => 10,
                            'name' => 'Calibri',
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]
                );

                $event->sheet->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A'     => 10,
            'B'     => 15,
            'C'     => 20,
            'D'     => 20,
            'E'     => 15,
            'F'     => 15,
            'G'     => 15,
        ];
    }

    public function headings(): array
    {
        return [
            [$this->judul_report],
            [
                'No.',
                'Tanggal Transaksi',
                'Kode',
                'Keterangan',
                'Debet',
                'Kredit',
                'Saldo',
            ]
        ];
    }

    public function customProcessDataKasKecilToExcel($model)
    {
        $nomor = 0;
        foreach ($model as $key => $kas_kecils) {
            $nomor++;
            $data[$key]['nomor']                = $nomor;
            $data[$key]['tanggal_transaksi']    = date('d-m-Y', strtotime($kas_kecils->tanggal_transaksi));
            $data[$key]['kode_mata_anggaran']   = optional($kas_kecils->mata_anggaran)->kode;
            $data[$key]['nama_transaksi']       = $kas_kecils->nama_transaksi;
            $data[$key]['debet']                = $kas_kecils->debet;
            $data[$key]['kredit']               = $kas_kecils->kredit;
            $data[$key]['saldo']                = $kas_kecils->saldo;
        }

        return $data;
    }
}
