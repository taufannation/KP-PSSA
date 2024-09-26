<?php

namespace Database\Factories;

use App\Models\DataSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataSiswaFactory extends Factory
{
    protected $model = DataSiswa::class;

    public function definition()
    {

        return [
            'nama' => $this->faker->name,
            'tanggal_lahir' => $this->faker->date,
            'jenis_kelamin'        => $this->faker->randomElement(['L', 'P']),
            'pendidikan_terakhir' => $this->faker->randomElement(['SD', 'SMP', 'SMA']),
            'nama_ayah' => $this->faker->name,
            'nama_ibu' => $this->faker->name,
            'pekerjaan_orangtua' => $this->faker->jobTitle,
            'alamat' => $this->faker->address,
            'tanggal_masuk' => $this->faker->date,
        ];
    }
}
