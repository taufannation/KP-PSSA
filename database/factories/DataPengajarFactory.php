<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataPengajarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' =>$this->faker->name,
            'jenis_kelamin'=>$this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'usia' =>$this->faker->numberBetween(20, 45),

        ];
    }
}
