<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Comodities;
use Illuminate\Database\Seeder;

class ComoditiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comodities = [
            [
                'comodity_locations_id' => 2,
                'item_code' => 'A001',
                'name' => 'Kursi Belajar',
                'brand' => 'Polaris',
                'material' => 'Stainless',
                'date_of_purchase' => Carbon::createFromFormat('d-m-Y', '15-01-2022')->format('d-m-Y'),
                'condition' => 1,
                'quantity' => 15,
                'price' => '100.000',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'comodity_locations_id' => 2,
                'item_code' => 'A002',
                'name' => 'Komputer',
                'brand' => 'Dell',
                'material' => 'Plastic', // Ganti dengan bahan yang sesuai
                'date_of_purchase' => Carbon::createFromFormat('d-m-Y', '15-01-2022')->format('d-m-Y'),
                'condition' => 1,
                'quantity' => 3,
                'price' => '400.000',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'comodity_locations_id' => 1,
                'item_code' => 'A003',
                'name' => 'Meja Kantor',
                'brand' => 'IKEA',
                'material' => 'Wood', // Ganti dengan bahan yang sesuai
                'date_of_purchase' => Carbon::createFromFormat('d-m-Y', '15-01-2022')->format('d-m-Y'),
                'condition' => 2,
                'quantity' => 10,
                'price' => '150.000',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'comodity_locations_id' => 1,
                'item_code' => 'A004',
                'name' => 'Printer',
                'brand' => 'HP',
                'material' => 'Plastic', // Ganti dengan bahan yang sesuai
                'date_of_purchase' => Carbon::createFromFormat('d-m-Y', '15-01-2022')->format('d-m-Y'),
                'condition' => 1,
                'quantity' => 5,
                'price' => '200.000',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'comodity_locations_id' => 2,
                'item_code' => 'A005',
                'name' => 'Lemari Arsip',
                'brand' => 'Krisbow',
                'material' => 'Metal', // Ganti dengan bahan yang sesuai
                'date_of_purchase' => Carbon::createFromFormat('d-m-Y', '15-01-2022')->format('d-m-Y'),
                'condition' => 1,
                'quantity' => 8,
                'price' => '300.000',
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
        ];

        // Insert data ke dalam tabel comodities
        foreach ($comodities as $data) {
            Comodities::create($data);
        }
    }
}
