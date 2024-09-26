<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $locations = [
            'Ruang Tamu',
            'Gudang',
            'WC'
        ];
        $descriptions = [
            '-',
            '-',
            '-',
        ];

        if (count($locations) === count($descriptions)) {
            foreach ($locations as $index => $location) {
                DB::table('comodity_locations')->insert([
                    'name' => $location,
                    'description' => $descriptions[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
