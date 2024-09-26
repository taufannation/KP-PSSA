<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTabungansTableSeeder extends Seeder
{
    public function run()
    {
        // Insert data into kategori_tabungans table
        DB::table('kategori_tabungans')->insert([
            ['kode' => '0', 'nama' => 'SALDO AWAL', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '01', 'nama' => 'PEMASUKAN', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '02', 'nama' => 'PENGELUARAN', 'created_at' => now(), 'updated_at' => now()],
            // Add other records as needed
        ]);

        // You can add more seed data as necessary
    }
}
