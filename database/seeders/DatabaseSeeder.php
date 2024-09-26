<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserTableSeeder::class);
        $this->call(KategoriTabungansTableSeeder::class);
        // $this->call(ComodityLocationSeeder::class);
        // $this->call(ComoditiesSeeder::class);
        $this->call(SchoolOperationalSeeder::class);
        $this->call(KasKecilSeeder::class);
    }
}
