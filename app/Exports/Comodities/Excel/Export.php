<?php

namespace App\Exports\Comodities\Excel;

use App\Models\comodities;
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
        $comodities = comodities::all();
        return collect([
            $this->customProcessDataComoditiesToExcel($comodities)
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
                $event->sheet->styleCells(
                    'A3:G3',
                    [
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                            'name' => 'Calibri',
                            'color' => ['rgb' => '000000'],
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                    ]
                );
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');

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
                $event->sheet->mergeCells('A3:G3');
                $event->sheet->mergeCells('A4:G4');

                $baris_awal = $this->row_number++;
                $baris_akhir = $baris_awal;

                # HEADER TABLE
                $event->sheet->styleCells(
                    'A' . $baris_awal . ':k' . $baris_akhir,
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
                    'A' . $baris_awal . ':K' . $baris_akhir,
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
                    'E' . $baris_awal . ':G' . $baris_akhir,
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
            'K'     => 45,

        ];
    }

    public function headings(): array
    {
        return [
            [' '],
            ['LEMBAGA KESEJAHTERAAN SOSIAL ANAK FAJAR HARAPAN'],
            ['"DATA ASSET"'],
            [$this->judul_report],
            [
                'No.',
                'Kode Barang',
                'Nama Barang',
                'Merek',
                'Bahan',
                'Lokasi',
                'Tahun Pembelian',
                'Kondisi',
                'Kuantitas',
                'Harga',
                'Keterangan'
            ]
        ];
    }

    public function customProcessDataComoditiesToExcel($model)
    {
        foreach ($model as $key => $comodity) {
            $data[$key]['no'] = $key + 1;
            $data[$key]['item_code'] = $comodity->item_code;
            $data[$key]['name'] = $comodity->name;
            $data[$key]['brand'] = $comodity->brand;
            $data[$key]['material'] = $comodity->material;
            $data[$key]['location'] = $comodity->comodity_locations->name;
            $data[$key]['date_of_purchase'] = $comodity->date_of_purchase;
            $data[$key]['condition'] = $this->checkComodityConditions($comodity);
            $data[$key]['quantity'] = $comodity->quantity;
            $data[$key]['price'] = number_format($comodity->price, 3, ',', '.');
            $data[$key]['note'] = $comodity->note;
        }

        return $data;
    }

    public function checkComodityConditions($comodity)
    {
        if ($comodity->condition === 1) {
            $condition = 'Baru';
        } elseif ($comodity->condition === 2) {
            $condition = 'Baik';
        } elseif ($comodity->condition === 3) {
            $condition = 'Rusak';
        } else {
            $condition = 'Hilang';
        }

        return $condition;
    }
}









// <?php

// namespace App\Exports\Comodities\Excel;

// use App\Models\comodities;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Events\AfterSheet;

// class Export implements FromCollection, WithHeadings, ShouldAutoSize
// {
//     /**
//      * @return \Illuminate\Support\Collection
//      */
//     public function collection()
//     {
//         $comodities = comodities::all();
//         return collect([
//             $this->customProcessDataComoditiesToExcel($comodities)
//         ]);
//     }

//     public function headings(): array
//     {
//         return [
//             'No.',
//             'Kode Barang',
//             'Nama Barang',
//             'Merek',
//             'Bahan',
//             'Lokasi',
//             'Tahun Pembelian',
//             'Kondisi',
//             'Kuantitas',
//             'Harga',
//             'Keterangan'
//         ];
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
//                 $lastRow = $event->sheet->getDelegate()->getHighestRow();

//                 for ($row = 1; $row <= $lastRow; $row++) {
//                     for ($col = 'A'; $col <= $lastColumn; $col++) {
//                         $event->sheet->getDelegate()->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
//                     }
//                 }

//                 $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->getFont()->setSize(14);
//             },
//         ];
//     }




//     public function customProcessDataComoditiesToExcel($model)
//     {
//         foreach ($model as $key => $comodity) {
//             $data[$key]['no'] = $key + 1;
//             $data[$key]['item_code'] = $comodity->item_code;
//             $data[$key]['name'] = $comodity->name;
//             $data[$key]['brand'] = $comodity->brand;
//             $data[$key]['material'] = $comodity->material;
//             $data[$key]['location'] = $comodity->comodity_locations->name;
//             $data[$key]['date_of_purchase'] = $comodity->date_of_purchase;
//             $data[$key]['condition'] = $this->checkComodityConditions($comodity);
//             $data[$key]['quantity'] = $comodity->quantity;
//             $data[$key]['price'] = $comodity->price;
//             $data[$key]['note'] = $comodity->note;
//         }

//         return $data;
//     }

//     public function checkComodityConditions($comodity)
//     {
//         if ($comodity->condition === 1) {
//             $condition = 'Baru';
//         } elseif ($comodity->condition === 2) {
//             $condition = 'Baik';
//         } elseif ($comodity->condition === 3) {
//             $condition = 'Rusak';
//         } else {
//             $condition = 'Hilang';
//         }

//         return $condition;
//     }
// }
