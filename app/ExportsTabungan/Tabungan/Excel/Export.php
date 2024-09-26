<?php

namespace App\ExportsTabungan\Tabungan\Excel;

use App\Models\Tabungan;
use App\Models\KategoriTabungan;
use App\Models\JenisTransaksiTabungan;
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
    protected $filter_data, $row_number, $judul_report;

    public function __construct($filter_data = array(), $judul_report = '')
    {
        $this->filter_data  = $filter_data;
        $this->row_number   = 5;
        $this->judul_report = $judul_report;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Tabungan::query();

        # JIKA DICENTANG, MAKA FILTER TANGGAL MULAI s/d TANGGAL SELESAI
        if (!empty($this->filter_data['enable_filter'])) {
            $query->whereBetween('tanggal_transaksi', [
                date('Y-m-d', strtotime($this->filter_data['start_date'])),
                date('Y-m-d', strtotime($this->filter_data['end_date']))
            ]);
        }

        # JIKA DIFILTER DROPDOWN MATA ANGGARAN
        if (!empty($this->filter_data['kategori_tabungan_id'])) {
            $query->where('kategori_tabungan_id', $this->filter_data['kategori_tabungan_id']);
        }

        $query->with(['kategori_tabungan', 'jenis_transaksi_tabungan']);

        $query->orderBy('tanggal_transaksi', 'asc');

        $tabungan = $query->get();

        return collect([
            $this->customProcessDataTabunganToExcel($tabungan)
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
                    'A2:G2',
                    [
                        'font' => [
                            'bold' => true,
                            'size' => 13,
                            'name' => 'Calibri',
                            'color' => ['rgb' => 'FF0000'],
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                    ]
                );
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');

                # SUB HEADING
                $event->sheet->styleCells(
                    'A4:G4',
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
                $event->sheet->mergeCells('A3:H3');
                $event->sheet->mergeCells('A4:H4');

                $baris_awal = $this->row_number++;
                $baris_akhir = $baris_awal;

                # HEADER TABLE
                $event->sheet->styleCells(
                    'A' . $baris_awal . ':H' . $baris_akhir,
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
                    'A' . $baris_awal . ':D' . $baris_akhir,
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
                    'E' . $baris_awal . ':E' . $baris_akhir,
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
                    'F' . $baris_awal . ':H' . $baris_akhir,
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
            'E'     => 40,
            'F'     => 15,
            'G'     => 15,
            'H'     => 15,
        ];
    }

    public function headings(): array
    {
        return [
            [' '],
            ['LEMBAGA KESEJAHTERAAN SOSIAL ANAK'],
            [''],
            [$this->judul_report],            
            [
                'No.',
                'Tanggal Transaksi',
                'Jenis Tabungan',
                'Jenis Transaksi',
                'Keterangan',
                'Debet',
                'Kredit',
                'Saldo',
            ]
        ];
    }

    public function customProcessDataTabunganToExcel($model)
    {
        $nomor = 0;
        $data = [];

        foreach ($model as $key => $tabungan) {
            $nomor++;
            $data[$key]['nomor']                            = $nomor;
            $data[$key]['tanggal_transaksi']                = date('d-m-Y', strtotime($tabungan->tanggal_transaksi));
            $data[$key]['nama_kategori_tabungan']           = optional($tabungan->kategori_tabungan)->nama;
            $data[$key]['nama_jenis_transaksi_tabungan']    = optional($tabungan->jenis_transaksi_tabungan)->nama;
            $data[$key]['keterangan']                       = $tabungan->keterangan;
            $data[$key]['debet']                            = number_format($tabungan->debet, 2, ',', '.');
            $data[$key]['kredit']                           = number_format($tabungan->kredit, 2, ',', '.');
            $data[$key]['saldo']                            = number_format($tabungan->saldo, 2, ',', '.');
        }

        return $data;
    }
}
