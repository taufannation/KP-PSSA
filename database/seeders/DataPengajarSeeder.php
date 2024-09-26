<?php

namespace Database\Seeders;

use App\Models\DataPengajar;
use Illuminate\Database\Seeder;

class DataPengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataPengajar::factory(5)->create();
    }
}
